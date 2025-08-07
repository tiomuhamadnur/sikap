@extends('layouts.base')

@section('header')
    <title>Kunjungan</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Kunjungan
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
                                    data-bs-target="#exportModal" data-url="#">
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
                <form action="{{ route('visit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="project_id">Project</label>
                            <select class="form-select" name="project_id" id="project_id" required>
                                <option value="" selected disabled>- select project -</option>
                                @foreach ($projects as $item)
                                    <option value="{{ $item->id }}">{{ $item->profile->name ?? null }} ({{ $item->periode->name ?? null }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="visit_type_id">Tipe Kunjungan</label>
                            <select class="form-select" name="visit_type_id" id="visit_type_id" required>
                                <option value="" selected disabled>- select tipe kunjungan -</option>
                                @foreach ($visit_type as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                            <label class="form-label required" for="name">Hasil Kunjungan</label>
                            <textarea class="form-control" name="name" id="name" placeholder="Input hasil kunjungan" rows="6" required></textarea>
                        <div class="mb-3">
                            <label class="form-label required" for="date">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date"
                                placeholder="Input tanggal" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="desa_id">Desa</label>
                            <select class="form-select" name="desa_id" id="desa_id" required>
                                <option value="" selected disabled>- select desa -</option>
                                @foreach ($desa as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} ({{ $item->code }}) - Kec. {{ $item->kecamatan->name ?? '#' }} - {{ $item->kecamatan->kabupaten->name ?? '#' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Detail Lokasi</label>
                            <textarea class="form-control" name="address" id="address" placeholder="Input detail lokasi" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="remark">Catatan (jika ada)</label>
                            <textarea class="form-control" name="remark" id="remark" placeholder="Input catatan" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="photo">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo"
                                placeholder="Input photo" autocomplete="off">
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
                            <label class="form-label required" for="project_id_edit">Project</label>
                            <select class="form-select" name="project_id" id="project_id_edit" required>
                                <option value="" selected disabled>- select project -</option>
                                @foreach ($projects as $item)
                                    <option value="{{ $item->id }}">{{ $item->profile->name ?? null }} ({{ $item->periode->name ?? null }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="visit_type_id_edit">Tipe Kunjungan</label>
                            <select class="form-select" name="visit_type_id" id="visit_type_id_edit" required>
                                <option value="" selected disabled>- select dapil -</option>
                                @foreach ($visit_type as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="name_edit">Hasil Kunjungan</label>
                            <textarea class="form-control" name="name" id="name_edit" placeholder="Input hasil kunjungan" rows="6" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="date_edit">Tanggal</label>
                            <input type="date" class="form-control" id="date_edit" name="date"
                                placeholder="Input tanggal" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="desa_id_edit">Desa</label>
                            <select class="form-select" name="desa_id" id="desa_id_edit" required>
                                <option value="" selected disabled>- select desa -</option>
                                @foreach ($desa as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} ({{ $item->code }}) - Kec. {{ $item->kecamatan->name ?? '#' }} - {{ $item->kecamatan->kabupaten->name ?? '#' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address_edit">Detail Lokasi</label>
                            <textarea class="form-control" name="address" id="address_edit" placeholder="Input detail lokasi" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="remark_edit">Catatan (jika ada)</label>
                            <textarea class="form-control" name="remark" id="remark_edit" placeholder="Input catatan" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="photo_edit">Photo</label>
                            <input type="file" class="form-control" id="photo_edit" name="photo"
                                placeholder="Input photo" autocomplete="off">
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
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var name = $(e.relatedTarget).data('name');
                var date = $(e.relatedTarget).data('date');
                var visit_type_id = $(e.relatedTarget).data('visit_type_id');
                var project_id = $(e.relatedTarget).data('project_id');
                var desa_id = $(e.relatedTarget).data('desa_id');
                var address = $(e.relatedTarget).data('address');
                var remark = $(e.relatedTarget).data('remark');

                document.getElementById("editForm").action = url;
                $('#name_edit').val(name);
                $('#date_edit').val(date);
                $('#visit_type_id_edit').val(visit_type_id);
                $('#project_id_edit').val(project_id);
                $('#desa_id_edit').val(desa_id);
                $('#address_edit').val(address);
                $('#remark_edit').val(remark);
            });
        });
    </script>
@endsection
