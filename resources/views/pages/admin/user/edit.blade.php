@extends('layouts.base')

@section('header')
    <title>Admin | User</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Ubah Data User
                    </h3>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Grid with Labels -->
                        <form action="{{ route('user.update', $user->uuid) }}" id="formAdd" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $user->name ?? '') }}"
                                        placeholder="input nama lengkap" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">No. HP/WA</label>
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                        value="{{ old('phone', $user->phone ?? '') }}"
                                        placeholder="contoh: 08xxxxxxxxxx" pattern="^(\+62|62|0)8[1-9][0-9]{6,9}$"
                                        required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control"
                                        placeholder="input email" value="{{ old('email', $user->email ?? '') }}"
                                        autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select class="form-select js-select2" name="gender_id" id="gender_id" required>
                                        <option value="" selected disabled>- pilih jenis kelamin -</option>
                                        @foreach ($gender as $item)
                                            <option value="{{ $item->id }}" @selected(old('gender_id', $user->gender_id) == $item->id)>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Role</label>
                                    <select class="form-select" name="role_id" id="role_id" required>
                                        <option value="" selected disabled>- pilih role -</option>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->id }}" @selected(old('role_id', $user->role_id) == $item->id)>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label">Project</label>
                                    <select class="form-select js-select2" name="project_id" id="project_id">
                                        <option value="" selected>- no project -</option>
                                        @foreach ($project as $item)
                                            <option value="{{ $item->id }}" @selected(old('project_id', $user->project_id) == $item->id)>
                                                {{ $item->profile->name ?? 'N/A' }} - ({{ $item->periode->name ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!-- END Form Grid with Labels -->
                    </div>
                </div>
            </div>
            <div class="block-header block-header-default d-flex justify-content-end">
                <a href="{{ route('user.index') }}" class="btn btn-lg btn-danger my-3 me-2">
                    <i class="fa fa-arror-left"></i>
                    Batal
                </a>
                <button type="submit" form="formAdd" class="btn btn-lg btn-primary my-3">
                    <i class="fa fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('javascript')
@endsection
