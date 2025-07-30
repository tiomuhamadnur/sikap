<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ProfileDataTable;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(ProfileDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.profile.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'front_title' => 'nullable|string',
            'name' => 'string|required',
            'back_title' => 'nullable|string',
        ]);

        Profile::updateOrCreate($data, $data);

        return redirect()->route('profile.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Profile::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'front_title' => 'nullable|string',
            'name' => 'string|required',
            'back_title' => 'nullable|string',
        ]);

        $data->update($rawData);
        return redirect()->route('profile.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Profile::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('profile.index')->withNotify('Data berhasil dihapus');
    }
}
