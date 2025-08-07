@extends('layouts.base')

@section('header')
    <title>Request</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Request
                    </h3>
                    <div class="my-2 mb-0 ms-3">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdown-default-primary"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-default-primary">
                                {{-- <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="fa fa-circle-plus"></i>
                                    Add New Data
                                </a> --}}
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
                            <label class="form-label required" for="request_type_edit">Tipe Request</label>
                            <input type="text" class="form-control" id="request_type_edit"
                                placeholder="Input tipe request" autocomplete="off" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="date_edit">Tanggal</label>
                            <input type="date" class="form-control" id="date_edit"
                                placeholder="Input tanggal" autocomplete="off" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="description_edit">Deskripsi</label>
                            <textarea class="form-control" id="description_edit" placeholder="input deskripsi" disabled rows="6"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="status_id_edit">Status</label>
                            <select class="form-select" name="status_id" id="status_id_edit" required>
                                <option value="" selected disabled>- select status -</option>
                                @foreach ($statuses as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
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

    <!-- Photo Modal -->
    <div class="modal modal-lg modal-blur fade" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form id="editForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Photo Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="text-center">
                                <img class="img-thumbnail" id="photo" src="#" alt="Tidak ada lampiran photo">
                            </div>
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
    <!-- END Photo Modal -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var date = $(e.relatedTarget).data('date');
                var request_type = $(e.relatedTarget).data('request_type');
                var status_id = $(e.relatedTarget).data('status_id');
                var description = $(e.relatedTarget).data('description');

                document.getElementById("editForm").action = url;
                $('#date_edit').val(date);
                $('#request_type_edit').val(request_type);
                $('#status_id_edit').val(status_id);
                $('#description_edit').val(description);
            });

            $('#photoModal').on('show.bs.modal', function(e) {
                var photo = $(e.relatedTarget).data('photo');
                document.getElementById("photo").src = photo;
            });
        });
    </script>
@endsection
