<?php

namespace App\Http\Controllers\admin;

use App\DataTables\VisitDataTable;
use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Project;
use App\Models\Visit;
use App\Models\VisitType;
use Illuminate\Http\Request;

class VisitController extends Controller
{
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
        $data = $request->validate([
            'visit_type_id' => 'numeric|required',
            'name' => 'string|required',
            'project_id' => 'numeric|required',
            'desa_id' => 'numeric|required',
            'date' => 'date|required',
            'address' => 'string|nullable',
            'remark' => 'string|nullable',
        ]);

        Visit::updateOrCreate($data, $data);

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
