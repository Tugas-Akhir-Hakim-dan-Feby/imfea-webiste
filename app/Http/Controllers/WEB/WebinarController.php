<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\GenerateBackground;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Webinar\CreateRequest;
use App\Models\User;
use App\Models\Webinar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    const PER_PAGE = 7;

    protected $webinar;

    public function __construct(Webinar $webinar)
    {
        $this->webinar = $webinar;
    }

    public function index()
    {
        $webinars = $this->webinar->where(function ($query) {
            if (
                auth()->user()->roles[0]->id == User::OPERATOR
            ) {
                $query->where('user_id', auth()->user()->id);
            }
        })->paginate(self::PER_PAGE);

        $data = [
            "title" => "Webinar",
            "webinars" => $webinars
        ];

        return view('webinar.index', $data);
    }

    public function loadMore(Request $request)
    {
        $webinars = $this->webinar->where('user_id', auth()->user()->id)->paginate(self::PER_PAGE, ['*'], 'page', $request->page);

        return view('webinar.load-more', compact('webinars'))->render();
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Baru Webinar"
        ];

        return view('webinar.create', $data);
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
            return MessageFixer::successMessage("selamat data `$webinar->title` berhasil disimpan.", route('web.webinar.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.webinar.create'));
        }
    }

    public function show(string $id)
    {
        //
    }

    public function meet(string $slug)
    {
        $webinar = $this->webinar->where("slug", $slug)->first();

        if (!$webinar) {
            abort(404);
        }

        return redirect($webinar->url);
    }

    public function edit(Webinar $webinar)
    {
        $data = [
            "title" => "Edit Webinar",
            "webinar" => $webinar
        ];

        return view('webinar.edit', $data);
    }

    public function update(CreateRequest $request, Webinar $webinar)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);

        try {
            $webinar->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("Selamat data `$webinar->title` berhasil disimpan.", route('web.webinar.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.webinar.index'));
        }
    }

    public function destroy(Webinar $webinar)
    {
        DB::beginTransaction();

        try {
            $webinar->delete();

            DB::commit();
            return MessageFixer::successMessage("Selamat data `$webinar->title` berhasil dihapus!", route('web.webinar.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.webinar.index'));
        }
    }

    public function background(Webinar $webinar)
    {
        return GenerateBackground::buildWebinar($webinar->title);
    }

    public function generateMembershipCard()
    {
        return GenerateBackground::build2();
        // $pdf = Pdf::loadView('templates.electronic_card.membership');
        // return $pdf->stream();

        // return view('templates.electronic_card.membership');
    }
}
