<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Training\CreateRequest;
use App\Http\Requests\WEB\Training\UpdateRequest;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TrainingController extends Controller
{
    protected $training;

    protected $perPage = 7;

    public function __construct(Training $training)
    {
        $this->training = $training;
    }

    public function index()
    {
        $trainings = $this->training->paginate($this->perPage);

        $data = [
            "title" => "Pelatihan",
            "trainings" => $trainings
        ];

        return view('training.admin', $data);
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Pelatihan"
        ];

        return view('training.create', $data);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
            "user_id" => auth()->user()->id
        ]);

        try {
            $file = $request->file('image_thumbnail');
            $filename = $file->getClientOriginalName();
            $filename = time() . '_' . $filename;

            $file->move(public_path(Training::pathImageThumbnail()), $filename);

            $request->merge([
                "thumbnail" => Training::pathImageThumbnail() . '/' . $filename
            ]);

            $training = $this->training->create($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$training->title` berhasil disimpan.", route('web.training.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.create'));
        }
    }

    public function show(Training $training)
    {
        $data = [
            "title" => $training->title,
            "training" => $training
        ];

        return view('training.show', $data);
    }

    public function edit(Training $training)
    {
        $data = [
            "title" => "Edit Pelatihan",
            "training" => $training
        ];

        return view('training.edit', $data);
    }

    public function update(UpdateRequest $request, Training $training)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
            "user_id" => auth()->user()->id
        ]);

        try {
            if ($request->hasFile("image_thumbnail")) {
                $path = str_replace(url('/'), '', $training->thumbnail);
                File::delete(public_path($path));

                $file = $request->file('image_thumbnail');
                $filename = $file->getClientOriginalName();
                $filename = time() . '_' . $filename;

                $file->move(public_path(Training::pathImageThumbnail()), $filename);

                $request->merge([
                    "thumbnail" => Training::pathImageThumbnail() . '/' . $filename
                ]);
            }

            $training->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$training->title` berhasil disimpan.", route('web.training.show', $training));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.edit', $training));
        }
    }

    public function destroy(Training $training)
    {
        DB::beginTransaction();

        try {
            if ($training->thumbnail) {
                $path = str_replace(url('/'), '', $training->thumbnail);
                File::delete(public_path($path));
            }

            $training->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$training->title` berhasil dihapus.", route('web.training.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.training.index'));
        }
    }
}
