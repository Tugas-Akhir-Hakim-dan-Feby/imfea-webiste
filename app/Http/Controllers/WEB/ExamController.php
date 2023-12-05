<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Enums\ExamTypeEnum;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Exam\ExamRequest;
use App\Models\Exam;
use App\Models\Topic;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    protected $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function index()
    {
        //
    }

    public function create(Training $training)
    {
        $data = [
            "title" => "Tambah Pertanyaan",
            "training" => $training,
            "exam" => null,
            "questionTypes" => ExamTypeEnum::get()
        ];

        return view('training.exam.form', $data);
    }

    public function store(Training $training, ExamRequest $request)
    {
        DB::beginTransaction();

        $topic = $this->topic->findOrFail($request->topic_id);

        try {
            $exam = $topic->exams()->create($request->all());

            if ($request->has('answers')) {
                foreach ($request->answers as $answer) {
                    $exam->answers()->create([
                        "answer" => $answer
                    ]);
                }

                $exam->update([
                    "exam_answer_id" => $request->correct_answer
                ]);
            }

            DB::commit();
            return MessageFixer::successMessage("selamat data pertanyaan `$topic->title` berhasil disimpan.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.exam.create', $training));
        }
    }

    public function show(Training $training, Exam $exam)
    {
        //
    }

    public function edit(Training $training, Exam $exam)
    {
        $data = [
            "title" => "Edit Pertanyaan",
            "training" => $training,
            "exam" => $exam,
            "questionTypes" => ExamTypeEnum::get()
        ];

        return view('training.exam.form', $data);
    }

    public function update(Request $request, Exam $exam)
    {
        //
    }

    public function destroy(Exam $exam)
    {
        //
    }
}
