<?php

namespace App\Http\Controllers\admin;

use App\DataTables\VisitDataTable;
use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Project;
use App\Models\Visit;
use App\Models\VisitPhoto;
use App\Models\VisitType;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index(VisitDataTable $dataTable)
    {
        $visit_type = VisitType::orderBy('name', 'ASC')->get();
        $desa = Desa::orderBy('name', 'ASC')->get();
        $projects = Project::all();
        return $dataTable->render('pages.user.visit.index', compact([
            'visit_type',
            'projects',
            'desa',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'visit_type_id' => 'numeric|required',
            'name' => 'string|required',
            'project_id' => 'numeric|required',
            'desa_id' => 'numeric|required',
            'date' => 'date|required',
            'address' => 'string|nullable',
            'remark' => 'string|nullable',
        ]);

        $request->validate([
            'photo' => 'required|file|image',
        ]);

        $data = Visit::updateOrCreate($rawData, $rawData);

        if ($request->hasFile('photo')) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $request->file('photo'),
                'photo/visit/', // Path untuk photo
                400
            );

            foreach($data->visit_photos as $photo) {
                Storage::delete($photo->photo);

                // Update path photo di database
                VisitPhoto::updateOrCreate([
                    'visit_id' => $data->id,
                ], [
                    'visit_id' => $data->id,
                    'photo' => $photoPath
                ]);
            }
        }

        return redirect()->route('visit.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Visit::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'visit_type_id' => 'numeric|required',
            'name' => 'string|required',
            'project_id' => 'numeric|required',
            'desa_id' => 'numeric|required',
            'date' => 'date|required',
            'address' => 'string|nullable',
            'remark' => 'string|nullable',
        ]);

        $data->update($rawData);
        return redirect()->route('visit.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Visit::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('visit.index')->withNotify('Data berhasil dihapus');
    }
}
