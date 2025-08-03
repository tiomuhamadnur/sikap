<?php

namespace App\Http\Controllers\admin;

use App\DataTables\VisitTypeDataTable;
use App\Http\Controllers\Controller;
use App\Models\VisitType;
use Illuminate\Http\Request;

class VisitTypeController extends Controller
{
    public function index(VisitTypeDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.visit-type.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        VisitType::updateOrCreate($data, $data);

        return redirect()->route('visit-type.index')->withNotify('Data berhasil ditambahkan');
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
        $data = VisitType::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('visit-type.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = VisitType::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('visit-type.index')->withNotify('Data berhasil dihapus');
    }
}
