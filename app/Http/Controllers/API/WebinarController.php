<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\Filters\Webinar\ShowByAuth;
use App\Http\Requests\API\Webinar\CreateRequest;
use App\Http\Resources\Webinar\WebinarCollection;
use App\Http\Resources\Webinar\WebinarDetail;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WebinarController extends Controller
{
    protected $webinar;

    public function __construct(Webinar $webinar)
    {
        $this->webinar = $webinar;
    }

    public function index(Request $request)
    {
        $webinars = app(Pipeline::class)
            ->send($this->webinar->query())
            ->through([
                ShowByAuth::class,
            ])
            ->thenReturn()
            ->paginate($request->per_page);

        return new WebinarCollection($webinars);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
            "user_id" => auth()->user()->id
        ]);

        try {
            $webinar = $this->webinar->create($request->all());

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `$webinar->title` berhasil disimpan.", MessageFixer::HTTP_CREATED, $webinar);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register($id)
    {
        DB::beginTransaction();

        $webinar = $this->webinar->find($id);

        if (!$webinar) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        if ($webinar->webinarParticipant) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf anda sudah terdaftar di webinar ini!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            $webinar->participant()->create([
                "user_id" => auth()->user()->id
            ]);

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "Selamat anda berhasil terdaftar di `$webinar->title`.", MessageFixer::HTTP_CREATED, $webinar);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $webinar = $this->webinar->find($id);

        if (!$webinar) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        return new WebinarDetail($webinar);
    }

    public function update(CreateRequest $request, string $id)
    {
        DB::beginTransaction();

        $webinar = $this->webinar->find($id);

        if (!$webinar) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);

        try {
            $webinar->update($request->all());

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `$webinar->title` berhasil disimpan.", MessageFixer::HTTP_CREATED, $webinar);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $webinar = $this->webinar->find($id);

        if (!$webinar) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            $webinar->delete();

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `$webinar->title` berhasil dihapus.", MessageFixer::HTTP_CREATED, $webinar);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
