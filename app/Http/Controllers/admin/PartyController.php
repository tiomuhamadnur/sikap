<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PartyDataTable;
use App\Http\Controllers\Controller;
use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function index(PartyDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.party.index');
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

        Party::updateOrCreate($data, $data);

        return redirect()->route('party.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Party::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('party.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Party::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('party.index')->withNotify('Data berhasil dihapus');
    }
}
