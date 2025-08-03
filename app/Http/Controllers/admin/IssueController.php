<?php

namespace App\Http\Controllers\admin;

use App\DataTables\IssueDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Issue;
use App\Models\Status;
use App\Models\Visit;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(IssueDataTable $dataTable)
    {
        $visits = Visit::orderBy('date', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $statuses = Status::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.user.issue.index', compact([
            'visits',
            'categories',
            'statuses',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'visit_id' => 'numeric|required',
            'name' => 'string|required',
            'category_id' => 'numeric|required',
            'status_id' => 'numeric|required',
            'remark' => 'string|nullable',
        ]);

        Issue::updateOrCreate($data, $data);

        return redirect()->route('issue.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Issue::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'visit_id' => 'numeric|required',
            'name' => 'string|required',
            'category_id' => 'numeric|required',
            'status_id' => 'numeric|required',
            'remark' => 'string|nullable',
        ]);

        $data->update($rawData);
        return redirect()->route('issue.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Issue::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('issue.index')->withNotify('Data berhasil dihapus');
    }
}
