<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Course\CourseRequest;
use App\Models\Course;
use App\Models\Topic;
use App\Models\Training;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseController extends Controller
{
    protected $topic, $training, $course, $exam;

    public function __construct(Topic $topic, Training $training, Course $course, Exam $exam)
    {
        $this->topic = $topic;
        $this->training = $training;
        $this->course = $course;
        $this->exam = $exam;
    }

    public function index()
    {
        //
    }

    public function create(Training $training)
    {

        $data = [
            "title" => "Tambah Materi Baru",
            "training" => $training,
        ];

        return view('training.course.create', $data);
    }

    public function store(CourseRequest $request, Training $training)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);

        try {
            $training->courses()->create($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$request->title` berhasil disimpan.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.course.create', $training));
        }
    }

    public function show(Course $course)
    {
        //
    }

    public function showSlug($trainingSlug, $courseSlug)
    {
        $training = $this->training->whereSlug($trainingSlug)->first();
        if (!$training) {
            abort(404);
        }

        $course = $this->course->whereSlug($courseSlug)->first();
        if (!$course) {
            abort(404);
        }

        $nextCourse = $course->topic
            ->courses()
            ->where('id', '>', $course->id)
            ->first();

        if (!$nextCourse) {
            $nextCourse = $training->topics()
                ->where('id', '>', $course->topic_id)
                ->first();
            if ($nextCourse) {
                $nextCourse = $nextCourse->courses()
                    ->first();
            }
        }

        $data = [
            "training" => $training,
            "course" => $course,
            "nextCourse" => $nextCourse,
            "isExam" => false
        ];

        return view('templates.course', $data);
    }

    public function examPreview($trainingSlug)
    {
        $training = $this->training->whereSlug($trainingSlug)->first();
        if (!$training) {
            abort(404);
        }

        $data = [
            "training" => $training,
            "isExam" => true
        ];

        return view('templates.course', $data);
    }

    public function exam($trainingSlug, Request $request)
    {
        $training = $this->training->whereSlug($trainingSlug)->first();
        if (!$training) {
            abort(404);
        }

        if (!$training->trainingParticipant->check_in_exam) {
            $training->trainingParticipant()->update([
                "check_in_exam" => Carbon::now()->addHours(1)
            ]);
        }

        $exams = $this->exam->where("training_id", $training->id)->paginate(1);

        $data = [
            "training" => $training,
            "exams" => $exams
        ];

        return view('templates.exam', $data);
    }

    public function processSubmitted(Request $request, $trainingSlug, $courseSlug)
    {
        DB::beginTransaction();

        $training = $this->training->whereSlug($trainingSlug)->first();
        if (!$training) {
            abort(404);
        }

        $course = $this->course->findOrFail($request->course_id);

        try {
            if (!$course->visitor) {
                $course->visitor()->create([
                    "user_id" => auth()->user()->id
                ]);
            }

            DB::commit();
            return MessageFixer::successMessage("pelajaran ini berhasil kamu selesaikan. lanjut ke materi selanjutnya ya.", route('web.training.course.slug', [
                'trainingSlug' => $training->slug,
                'courseSlug' => $courseSlug,
            ]));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.course.slug', [
                'trainingSlug' => $training->slug,
                'courseSlug' => $course->slug,
            ]));
        }
    }

    public function processFinished(Request $request, $trainingSlug)
    {
        DB::beginTransaction();

        $training = $this->training->whereSlug($trainingSlug)->first();
        if (!$training) {
            abort(404);
        }

        $course = $this->course->findOrFail($request->course_id);

        try {
            if (!$course->visitor) {
                $course->visitor()->create([
                    "user_id" => auth()->user()->id
                ]);
            }

            DB::commit();
            return MessageFixer::successMessage("pelajaran ini berhasil kamu selesaikan. lanjut ke materi selanjutnya ya.", route('web.training.course.slug.exam.preview', [
                'trainingSlug' => $training->slug,
            ]));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.course.slug', [
                'trainingSlug' => $training->slug,
                'courseSlug' => $course->slug,
            ]));
        }
    }

    public function saveAnswer(Request $request, $trainingSlug)
    {
        DB::beginTransaction();

        $exam = $this->exam->findOrFail($request->exam_id);
        $training = $this->training->whereSlug($trainingSlug)->first();

        try {
            if ($exam->memberAnswerByAuth) {
                $exam->memberAnswerByAuth()->update([
                    'answer' => $request->answer
                ]);
            } else {
                $exam->memberAnswerByAuth()->create([
                    'type' => $request->type,
                    'user_id' => auth()->user()->id,
                    'answer' => $request->answer
                ]);
            }


            if ($request->has('is_finish')) {
                $training->trainingParticipant()->update([
                    "check_out_exam" => now()
                ]);

                DB::commit();
                return MessageFixer::successMessage("jawaban berhasil disimpan. silahkan tunggu hasil penilaian dari pemateri.", route('web.training.course.slug.exam.preview', [
                    'trainingSlug' => $trainingSlug,
                ]));
            }

            DB::commit();
            return MessageFixer::successMessage("jawaban berhasil disimpan.", route('web.training.course.slug.exam', [
                'trainingSlug' => $trainingSlug,
                'page' => $request->page
            ]));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.course.slug.exam', $trainingSlug));
        }
    }

    public function expired(Request $request, $trainingSlug)
    {
        DB::beginTransaction();

        $training = $this->training->whereSlug($trainingSlug)->first();

        try {
            $training->trainingParticipant()->update([
                "check_out_exam" => now()
            ]);

            DB::commit();
            return MessageFixer::warningMessage("waktu ujian sudah habis, silahkan hubungi pemateri untuk mereset ulang.", route('web.training.course.slug.exam.preview', [
                'trainingSlug' => $trainingSlug,
            ]));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.course.slug.exam', $trainingSlug));
        }
    }

    public function edit(Training $training, Course $course)
    {
        $data = [
            "title" => "Edit Materi",
            "course" => $course,
            "training" => $training,
        ];

        return view('training.course.edit', $data);
    }

    public function update(
        CourseRequest $request,
        Training $training,
        Course $course
    ) {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);

        try {
            $course->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$request->title` berhasil disimpan.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.course.edit', $training));
        }
    }

    public function destroy(Training $training, Course $course)
    {
        DB::beginTransaction();

        try {
            $course->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$course->title` berhasil dihapus.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.show', $training));
        }
    }
}
