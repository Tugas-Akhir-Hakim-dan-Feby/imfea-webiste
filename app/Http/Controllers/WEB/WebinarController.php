<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\GenerateBackground;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Webinar\CreateRequest;
use App\Models\User;
use App\Models\Webinar;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    protected $perPage = 7;
    protected $webinar;

    public function __construct(Webinar $webinar)
    {
        $this->webinar = $webinar;
    }

    public function index()
    {
        $webinars = $this->webinar->where(function ($query) {
            if (
                auth()->user()->isOperator()
            ) {
                $query->where('user_id', auth()->user()->id);
            }

            if (
                auth()->user()->isMember()
            ) {
                $query->whereHas('participant');
            }
        });

        if (auth()->user()->isMember()) {
            return view('webinar.member', [
                "title" => "Webinar Saya",
                "webinars" => $webinars->get()
            ]);
        }

        return view('webinar.admin', [
            "title" => "Webinar",
            "webinars" => $webinars->paginate($this->perPage)
        ]);
    }

    public function all()
    {
        $this->perPage = 8;
        $dateNow = Carbon::now()->toDateString();

        $webinars = $this->webinar->where(function ($query) use ($dateNow) {
            if (
                auth()->user()->isOperator()
            ) {
                $query->where('user_id', auth()->user()->id);
            }

            if (
                auth()->user()->isMember()
            ) {
                $query->whereDoesntHave('participant');
            }

            $query->where('activity_date', '>=', $dateNow);
        });

        return view('webinar.all', [
            "title" => "Semua Webinar",
            "webinars" => $webinars->paginate($this->perPage)
        ]);
    }

    public function loadMore(Request $request)
    {
        $webinars = $this->webinar->where('user_id', auth()->user()->id)->paginate($this->perPage, ['*'], 'page', $request->page);

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

    public function register(Webinar $webinar)
    {
        DB::beginTransaction();

        try {
            $webinar->participant()->create([
                "user_id" => auth()->user()->id
            ]);

            DB::commit();
            return MessageFixer::successMessage("Selamat anda berhasil terdaftar di `$webinar->title`.", route('web.webinar.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.webinar.index'));
        }
    }

    public function show(Webinar $webinar)
    {
        $isNowMeet = false;
        $currentDateTime = Carbon::now();
        $targetDate = Carbon::parse($webinar->activity_date);
        $targetTime = Carbon::parse($webinar->activity_time);

        if ($currentDateTime->lessThan($targetDate) || $currentDateTime->lessThan($targetTime)) {
            $isNowMeet = true;
        }

        $data = [
            "title" => $webinar->title,
            "webinar" => $webinar,
            "isNowMeet" => $isNowMeet
        ];

        return view('webinar.show', $data);
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
}
