<?php

namespace App\Http\Controllers\admin;

use App\DataTables\RequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index(RequestDataTable $dataTable)
    {
        $statuses = Status::all();
        return $dataTable->render('pages.user.request.index', compact([
            'statuses',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        $data = ModelsRequest::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            'status_id' => 'required|numeric|exists:statuses,id'
        ]);

        $data->update($rawData);

        return redirect()->route('request.index')->withNotify('Data request dengan No. Ticket: ' . $data->ticket . ' berhasil diubah.');
    }

    public function destroy(string $uuid)
    {
        $data = ModelsRequest::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('request.index')->withNotify('Data berhasil dihapus');
    }
}
