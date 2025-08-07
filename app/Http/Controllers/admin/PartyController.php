<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PartyDataTable;
use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartyController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

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
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $request->validate([
            'photo' => 'required|file|image',
        ]);

        $data = Party::updateOrCreate($rawData, $rawData);

        if ($request->hasFile('photo')) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $request->file('photo'),
                'photo/party/', // Path untuk photo
                400
            );

            // Hapus file lama
            if ($data->logo) {
                Storage::delete($data->logo);
            }

            // Update path photo di database
            $data->update(['logo' => $photoPath]);
        }

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

        $request->validate([
            'photo' => 'nullable|file|image',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $request->file('photo'),
                'photo/party/', // Path untuk photo
                400
            );

            // Hapus file lama
            if ($data->logo) {
                Storage::delete($data->logo);
            }

            $rawData['logo'] = $photoPath;
        }

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
