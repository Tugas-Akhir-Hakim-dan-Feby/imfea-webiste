<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Course\CourseRequest;
use App\Models\Course;
use App\Models\Topic;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    protected $topic, $training, $course;

    public function __construct(Topic $topic, Training $training, Course $course)
    {
        $this->topic = $topic;
        $this->training = $training;
        $this->course = $course;
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
        ];

        return view('templates.course', $data);
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
