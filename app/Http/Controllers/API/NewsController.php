<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\API\News\CreateRequest;
use App\Http\Requests\API\News\UpdateRequest;
use App\Http\Resources\News\NewsCollection;
use App\Http\Resources\News\NewsDetail;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function index(Request $request)
    {
        $webinars = app(Pipeline::class)
            ->send($this->news->query())
            ->through([])
            ->thenReturn()
            ->paginate($request->per_page);

        return new NewsCollection($webinars);
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

            $file->move(public_path(News::pathImageThumbnail()), $filename);

            $request->merge([
                "thumbnail" => News::pathImageThumbnail() . '/' . $filename
            ]);

            $news = $this->news->create($request->all());

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `$news->title` berhasil disimpan.", MessageFixer::HTTP_CREATED, $news);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $news = $this->news->find($id);

        if (!$news) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        return new NewsDetail($news);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();

        $news = $this->news->find($id);

        if (!$news) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);

        try {
            if ($request->hasFile('image_thumbnail')) {
                $file = $request->file('image_thumbnail');
                $filename = $file->getClientOriginalName();
                $filename = time() . '_' . $filename;

                $file->move(public_path(News::pathImageThumbnail()), $filename);

                $request->merge([
                    "thumbnail" => News::pathImageThumbnail() . '/' . $filename
                ]);
            }

            $news->update($request->all());

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `$news->title` berhasil disimpan.", MessageFixer::HTTP_OK, $news);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateStatus($id)
    {
        DB::beginTransaction();

        $news = $this->news->find($id);

        if (!$news) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            $news->update([
                "status" => $news->status ? News::NON_ACTIVE : News::ACTIVE
            ]);

            if ($news->status) {
                $message = "selamat data `$news->title` berhasil di aktifkan.";
            } else {
                $message = "selamat data `$news->title` berhasil di nonaktifkan.";
            }

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, $message, MessageFixer::HTTP_OK, $news);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $news = $this->news->find($id);

        if (!$news) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf data tidak tersedia!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            if ($news->thumbnail) {
                $path = str_replace(url('/'), '', $news->thumbnail);
                File::delete(public_path($path));
            }

            $news->delete();

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `$news->title` berhasil dihapus.", MessageFixer::HTTP_OK, $news);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
