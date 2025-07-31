@extends('layouts.base')

@section('header')
    <title>Hasil Pemilu</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Hasil Pemilu
                    </h3>
                    <div class="my-2 mb-0 ms-3">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdown-default-primary"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-default-primary">
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="fa fa-circle-plus"></i>
                                    Add New Data
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-filter"></i>
                                    Filter
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="fa fa-file-import"></i>
                                    Import
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exportModal" data-url="{{ route('election.export.excel') }}">
                                    <i class="fa fa-file-export"></i>
                                    Export
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'class' => 'table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle',
                        'id' => 'datatable-excel'
                    ]) }}
                </div>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('modals')
    <!-- Add Modal -->
    <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('election.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="tps_id">TPS</label>
                            <select class="form-select" name="tps_id" id="tps_id" required>
                                <option value="" selected disabled>- select TPS -</option>
                                @foreach ($tps as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} - ({{ $item->dapil->project->profile->name ?? '#' }}) - ({{ $item->desa->name ?? '#' }}-{{ $item->desa->kecamatan->name ?? '#' }}-{{ $item->desa->kecamatan->kabupaten->name ?? '#' }}) - (Periode: {{ $item->dapil->project->periode->name ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="vote">Suara</label>
                            <input type="number" min="0" class="form-control" id="vote" name="vote"
                                placeholder="Input suara" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="vote_party">Suara Partai</label>
                            <input type="number" min="0" class="form-control" id="vote_party" name="vote_party"
                                placeholder="Input suara partai" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-plus"></i>
                            Create new
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Add Modal -->

    <!-- Edit Modal -->
    <div class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form id="editForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="tps_id_edit">TPS</label>
                            <select class="form-select" name="tps_id" id="tps_id_edit" required>
                                <option value="" selected disabled>- select TPS -</option>
                                @foreach ($tps as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} - ({{ $item->dapil->project->profile->name ?? '#' }}) - ({{ $item->desa->name ?? '#' }}-{{ $item->desa->kecamatan->name ?? '#' }}-{{ $item->desa->kecamatan->kabupaten->name ?? '#' }}) - (Periode: {{ $item->dapil->project->periode->name ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="vote_edit">Suara</label>
                            <input type="number" min="0" class="form-control" id="vote_edit" name="vote"
                                placeholder="Input suara" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="vote_party_edit">Suara Partai</label>
                            <input type="number" min="0" class="form-control" id="vote_party_edit" name="vote_party"
                                placeholder="Input suara partai" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-pencil"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Edit Modal -->

    <!-- Import Modal -->
    <div class="modal modal-blur fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('election.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Form Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="file">File Import <a class="text-success" title="Download template" href="{{ asset('media/import/Template_Import_Hasil_Pemilu.xlsx') }}" target="_blank"><i class="fa fa-file-excel"></i></a></label>
                            <input type="file" class="form-control" id="file" name="file"
                                placeholder="Input file import" autocomplete="off" accept=".xlsx" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-plus"></i>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Import Modal -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var tps_id = $(e.relatedTarget).data('tps_id');
                var vote = $(e.relatedTarget).data('vote');
                var vote_party = $(e.relatedTarget).data('vote_party');

                document.getElementById("editForm").action = url;
                $('#vote_edit').val(vote);
                $('#vote_party_edit').val(vote_party);
                $('#tps_id_edit').val(tps_id);
            });
        });
    </script>
@endsection
