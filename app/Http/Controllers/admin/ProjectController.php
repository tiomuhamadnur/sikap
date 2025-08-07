<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ProjectDataTable;
use App\Http\Controllers\Controller;
use App\Models\ElectionType;
use App\Models\Party;
use App\Models\Periode;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(ProjectDataTable $dataTable)
    {
        $parties = Party::orderBy('name', 'ASC')->get();
        $periodes = Periode::orderBy('name', 'ASC')->get();
        $profiles = Profile::orderBy('name', 'ASC')->get();
        $election_types = ElectionType::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.user.project.index', compact([
            'parties',
            'periodes',
            'profiles',
            'election_types',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'party_id' => 'numeric|required',
            'periode_id' => 'numeric|required',
            'profile_id' => 'numeric|required',
            'election_type_id' => 'numeric|required',
            'start_date' => 'date|required',
            'end_date' => 'date|required|gte:start_date',
            'expired_date' => 'date|required',
            'about' => 'string|required',
        ]);

        Project::updateOrCreate($data, $data);

        return redirect()->route('project.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Project::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'party_id' => 'numeric|required',
            'periode_id' => 'numeric|required',
            'profile_id' => 'numeric|required',
            'election_type_id' => 'numeric|required',
            'start_date' => 'date|required',
            'end_date' => 'date|required|gte:start_date',
            'expired_date' => 'date|required',
            'about' => 'string|required',
        ]);

        $data->update($rawData);
        return redirect()->route('project.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Project::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('project.index')->withNotify('Data berhasil dihapus');
    }
}
