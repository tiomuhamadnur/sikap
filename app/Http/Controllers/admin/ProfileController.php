<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ProfileDataTable;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

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
        $rawData = $request->validate([
            'front_title' => 'nullable|string',
            'name' => 'string|required',
            'back_title' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $request->validate([
            'photo' => 'required|file|image',
        ]);

        $data = Profile::updateOrCreate($rawData, $rawData);

        if ($request->hasFile('photo')) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $request->file('photo'),
                'photo/profile/', // Path untuk photo
                400
            );

            // Hapus file lama
            if ($data->photo) {
                Storage::delete($data->photo);
            }

            // Update path photo di database
            $data->update(['photo' => $photoPath]);
        }

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
            'email' => 'nullable|string',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $request->validate([
            'photo' => 'nullable|file|image',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $request->file('photo'),
                'photo/profile/', // Path untuk photo
                300
            );

            // Hapus file lama
            if ($data->photo) {
                Storage::delete($data->photo);
            }

            $rawData['photo'] = $photoPath;
        }

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
