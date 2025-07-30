<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ElectionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\TPS;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index(ElectionDataTable $dataTable)
    {
        $tps = TPS::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.user.election.index', compact([
            'tps',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tps_id' => 'numeric|required',
            'vote' => 'numeric|required',
            'vote_party' => 'numeric|required',
        ]);

        Election::updateOrCreate($data, $data);

        return redirect()->route('election.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Election::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'tps_id' => 'numeric|required',
            'vote' => 'numeric|required',
            'vote_party' => 'numeric|required',
        ]);

        $data->update($rawData);
        return redirect()->route('election.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Election::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('election.index')->withNotify('Data berhasil dihapus');
    }
}
