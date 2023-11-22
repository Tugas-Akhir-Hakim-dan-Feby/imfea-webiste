<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Topic\TopicRequest;
use App\Models\Topic;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TopicController extends Controller
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

    public function create()
    {
        //
    }

    public function store(TopicRequest $request, Training $training)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . '-' . Str::random(6))
        ]);

        try {
            $training->topics()->create($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$request->title` berhasil disimpan.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.show', $training));
        }
    }

    public function show(Topic $topic)
    {
        //
    }

    public function edit(Topic $topic)
    {
        //
    }

    public function update(
        TopicRequest $request,
        Training $training,
        Topic $topic
    ) {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . '-' . Str::random(6))
        ]);

        try {
            $topic->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$request->title` berhasil disimpan.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.show', $training));
        }
    }

    public function destroy(Training $training, Topic $topic)
    {
        DB::beginTransaction();

        try {
            $topic->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$topic->title` berhasil dihapus.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.show', $training));
        }
    }
}
