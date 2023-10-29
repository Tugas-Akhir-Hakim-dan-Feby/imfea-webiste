<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\News\CreateRequest;
use App\Http\Requests\WEB\News\UpdateRequest;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    const PER_PAGE = 10;

    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        $news = $this->news->where(function ($query) {
            if (
                auth()->user()->roles[0]->id == User::OPERATOR
            ) {
                $query->where('user_id', auth()->user()->id);
            }
        })->paginate(self::PER_PAGE);

        $data = [
            "title" => "Berita",
            "news" => $news
        ];

        return view('news.index', $data);
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Berita Baru",
        ];

        return view('news.create', $data);
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
            return MessageFixer::successMessage("selamat data `$news->title` berhasil disimpan.", route('web.news.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.news.create'));
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(News $news)
    {
        $data = [
            "title" => "Edit Berita",
            "news" => $news
        ];

        return view('news.edit', $data);
    }

    public function update(UpdateRequest $request, News $news)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);

        try {
            if ($request->hasFile('image_thumbnail')) {
                $path = str_replace(url('/'), '', $news->thumbnail);
                File::delete(public_path($path));

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
            return MessageFixer::successMessage("selamat data `$news->title` berhasil disimpan.", route('web.news.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.news.update', $news));
        }
    }

    public function destroy(News $news)
    {
        DB::beginTransaction();

        try {
            if ($news->thumbnail) {
                $path = str_replace(url('/'), '', $news->thumbnail);
                File::delete(public_path($path));
            }

            $news->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$news->title` berhasil dihapus.", route('web.news.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.news.index'));
        }
    }

    public function updateStatus(News $news)
    {
        DB::beginTransaction();

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
            return redirect()->back()->with('successMessage', $message);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.news.index'));
        }
    }

    public function uploadImageContent(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = $file->getClientOriginalName();
            $filename = time() . '_' . $filename;

            $file->move(public_path(News::pathImageContent()), $filename);

            $url = asset(News::pathImageContent() . '/' . $filename);
            return response()->json(['fileName' => $filename, 'uploaded' => 1, 'url' => $url]);
        }
    }
}
