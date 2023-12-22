<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\Region\City;
use App\Http\Facades\Region\Province;
use App\Http\Requests\WEB\RegionalRequest;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionalController extends Controller
{
    protected $regional;

    public function __construct(Regional $regional)
    {
        $this->regional = $regional;
    }

    public function index()
    {
        $data = [
            "title" => "Wilayah Cabang",
            "regionals" => $this->regional->paginate(10)
        ];

        return view('regional.index', $data);
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Baru",
            "regional" => null,
            "provinces" => Province::get(),
            "action" => route('web.regional.store')
        ];

        return view('regional.form', $data);
    }

    public function store(RegionalRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->regional->create($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data berhasil disimpan.", route('web.regional.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.regional.store'));
        }
    }

    public function show(Regional $regional)
    {
        //
    }

    public function edit(Regional $regional)
    {
        $data = [
            "title" => "Edit Wilayah",
            "regional" => $regional,
            "cities" => City::get($regional->province_id),
            "provinces" => Province::get(),
            "action" => route('web.regional.update', $regional)
        ];

        return view('regional.form', $data);
    }

    public function update(RegionalRequest $request, Regional $regional)
    {
        DB::beginTransaction();

        try {
            $regional->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data berhasil disimpan.", route('web.regional.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.regional.edit', $regional));
        }
    }

    public function destroy(Regional $regional)
    {
        DB::beginTransaction();

        try {
            $regional->korwilAssigns()->delete();
            $regional->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data berhasil dihapus.", route('web.regional.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.regional.index'));
        }
    }
}
