<?php

namespace App\Http\Controllers\admin;

use App\DataTables\DapilDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dapil;
use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Project;
use App\Models\Provinsi;
use App\Models\RelasiDapil;
use Illuminate\Http\Request;

class DapilController extends Controller
{
    public function index(DapilDataTable $dataTable)
    {
        $projects = Project::get();
        $provinsi = Provinsi::orderBy('name', 'ASC')->get();
        $kabupaten = Kabupaten::orderBy('name', 'ASC')->get();
        $kecamatan = Kecamatan::orderBy('name', 'ASC')->get();
        $desa = Desa::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.user.dapil.index', compact([
            'projects',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desa',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'project_id' => 'numeric|required',
        ]);

        Dapil::updateOrCreate($data, $data);

        return redirect()->route('dapil.index')->withNotify('Data berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        $data = Dapil::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'project_id' => 'numeric|required',
        ]);

        $data->update($rawData);
        return redirect()->route('dapil.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Dapil::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('dapil.index')->withNotify('Data berhasil dihapus');
    }
}
