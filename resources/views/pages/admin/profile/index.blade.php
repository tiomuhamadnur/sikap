@extends('layouts.base')

@section('header')
    <title>Admin | Profil Kandidat</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Profil Kandidat
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
                <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label optional" for="front_title">Front Title</label>
                            <input type="text" class="form-control" id="front_title" name="front_title"
                                placeholder="Input front title" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Input full name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="back_title">Back Title</label>
                            <input type="text" class="form-control" id="back_title" name="back_title"
                                placeholder="Input back title" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Input phone" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Input email" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Input description profile" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="5" placeholder="Input address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="photo">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo"
                                placeholder="Input photo" autocomplete="off" required accept="image/*">
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
                            <label class="form-label" for="front_title_edit">Front Title</label>
                            <input type="text" class="form-control" id="front_title_edit" name="front_title"
                                placeholder="Input front title" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="name_edit">Full Name</label>
                            <input type="text" class="form-control" id="name_edit" name="name"
                                placeholder="Input full name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="back_title">Back Title</label>
                            <input type="text" class="form-control" id="back_title_edit" name="back_title"
                                placeholder="Input back title" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="phone_edit">Phone</label>
                            <input type="text" class="form-control" id="phone_edit" name="phone"
                                placeholder="Input phone" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="email_edit">Email</label>
                            <input type="email" class="form-control" id="email_edit" name="email"
                                placeholder="Input email" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="description_edit">Description</label>
                            <textarea class="form-control" name="description" id="description_edit" rows="5" placeholder="Input description profile" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="address_edit">Address</label>
                            <textarea class="form-control" name="address" id="address_edit" rows="5" placeholder="Input address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="photo_edit">Photo</label>
                            <input type="file" class="form-control" id="photo_edit" name="photo"
                                placeholder="Input photo" autocomplete="off" accept="image/*">
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
                var front_title = $(e.relatedTarget).data('front_title');
                var back_title = $(e.relatedTarget).data('back_title');
                var phone = $(e.relatedTarget).data('phone');
                var email = $(e.relatedTarget).data('email');
                var description = $(e.relatedTarget).data('description');
                var address = $(e.relatedTarget).data('address');

                document.getElementById("editForm").action = url;
                $('#name_edit').val(name);
                $('#front_title_edit').val(front_title);
                $('#back_title_edit').val(back_title);
                $('#phone_edit').val(phone);
                $('#email_edit').val(email);
                $('#description_edit').val(description);
                $('#address_edit').val(address);
            });
        });
    </script>
@endsection
