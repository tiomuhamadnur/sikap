<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PeriodeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index(PeriodeDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.periode.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'start' => 'required|integer|digits:4|min:2000',
            'end' => 'required|integer|digits:4|min:2000|gte:start',
        ]);

        Periode::updateOrCreate($data, $data);

        return redirect()->route('periode.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Periode::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'required|string',
            'start' => 'required|integer|digits:4|min:2000',
            'end' => 'required|integer|digits:4|min:2000|gte:start',
        ]);

        $data->update($rawData);
        return redirect()->route('periode.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Periode::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('periode.index')->withNotify('Data berhasil dihapus');
    }
}
