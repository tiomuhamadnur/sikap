<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ElectionTypeDataTable;
use App\Http\Controllers\Controller;
use App\Models\ElectionType;
use Illuminate\Http\Request;

class ElectionTypeController extends Controller
{
    public function index(ElectionTypeDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.election-type.index');
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

        ElectionType::updateOrCreate($data, $data);

        return redirect()->route('election-type.index')->withNotify('Data berhasil ditambahkan');
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
        $data = ElectionType::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('election-type.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = ElectionType::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('election-type.index')->withNotify('Data berhasil dihapus');
    }
}
