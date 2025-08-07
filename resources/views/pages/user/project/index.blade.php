@extends('layouts.base')

@section('header')
    <title>Project</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Project
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
                                    data-bs-target="#exportModal">
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
                <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="party_id">Partai</label>
                            <select class="form-select" name="party_id" id="party_id" required>
                                <option value="" selected disabled>- select partai -</option>
                                @foreach ($parties as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="periode_id">Periode</label>
                            <select class="form-select" name="periode_id" id="periode_id" required>
                                <option value="" selected disabled>- select periode -</option>
                                @foreach ($periodes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="profile_id">Profil Kandidat</label>
                            <select class="form-select" name="profile_id" id="profile_id" required>
                                <option value="" selected disabled>- select profil kandidat -</option>
                                @foreach ($profiles as $item)
                                    <option value="{{ $item->id }}">{{ $item->front_title ?? null }} {{ $item->name }} {{ $item->back_title ?? null }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="election_type_id">Tipe Pemilihan</label>
                            <select class="form-select" name="election_type_id" id="election_type_id" required>
                                <option value="" selected disabled>- select tipe pemilihan -</option>
                                @foreach ($election_types as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                placeholder="Input start date" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="end_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                placeholder="Input end date" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="expired_date">Tanggal Expired Web</label>
                            <input type="date" class="form-control" id="expired_date" name="expired_date"
                                placeholder="Input expired date" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="about">Tentang Web</label>
                            <textarea class="form-control" name="about" id="about" rows="6" placeholder="input deskripsi web" required></textarea>
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
                            <label class="form-label required" for="party_id_edit">Partai</label>
                            <select class="form-select" name="party_id" id="party_id_edit" required>
                                <option value="" selected disabled>- select partai -</option>
                                @foreach ($parties as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="periode_id_edit">Periode</label>
                            <select class="form-select" name="periode_id" id="periode_id_edit" required>
                                <option value="" selected disabled>- select periode -</option>
                                @foreach ($periodes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="profile_id_edit">Profil Kandidat</label>
                            <select class="form-select" name="profile_id" id="profile_id_edit" required>
                                <option value="" selected disabled>- select profil kandidat -</option>
                                @foreach ($profiles as $item)
                                    <option value="{{ $item->id }}">{{ $item->front_title ?? null }} {{ $item->name }} {{ $item->back_title ?? null }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="election_type_id_edit">Tipe Pemilihan</label>
                            <select class="form-select" name="election_type_id" id="election_type_id_edit" required>
                                <option value="" selected disabled>- select tipe pemilihan -</option>
                                @foreach ($election_types as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="start_date_edit">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date_edit" name="start_date"
                                placeholder="Input start date" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="end_date_edit">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date_edit" name="end_date"
                                placeholder="Input end date" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="expired_date_edit">Tanggal Expired Web</label>
                            <input type="date" class="form-control" id="expired_date_edit" name="expired_date"
                                placeholder="Input expired date" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="about_edit">Tentang Web</label>
                            <textarea class="form-control" name="about" id="about_edit" rows="6" placeholder="input deskripsi web" required></textarea>
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
                var party_id = $(e.relatedTarget).data('party_id');
                var periode_id = $(e.relatedTarget).data('periode_id');
                var profile_id = $(e.relatedTarget).data('profile_id');
                var election_type_id = $(e.relatedTarget).data('election_type_id');
                var start_date = $(e.relatedTarget).data('start_date');
                var end_date = $(e.relatedTarget).data('end_date');
                var expired_date = $(e.relatedTarget).data('expired_date');
                var about = $(e.relatedTarget).data('about');

                document.getElementById("editForm").action = url;
                $('#party_id_edit').val(party_id);
                $('#periode_id_edit').val(periode_id);
                $('#profile_id_edit').val(profile_id);
                $('#election_type_id_edit').val(election_type_id);
                $('#start_date_edit').val(start_date);
                $('#end_date_edit').val(end_date);
                $('#expired_date_edit').val(expired_date);
                $('#about_edit').val(about);
            });
        });
    </script>
@endsection
