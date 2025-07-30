<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RelasiDapil;
use Illuminate\Http\Request;

class RelasiDapilController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dapil_id' => 'numeric|required',
            'kabupaten_id' => 'numeric|required',
        ]);

        RelasiDapil::updateOrCreate($data, $data);

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
        //
    }

    public function destroy(string $uuid)
    {
        $data = RelasiDapil::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('dapil.index')->withNotify('Data berhasil dihapus');
    }
}
