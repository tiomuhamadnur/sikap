@extends('layouts.base')

@section('header')
    <title>Dashboard</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Dashboard -->
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <form class="block block-rounded block-link-pop" action="{{ route('dashboard.index') }}" method="GET">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <select class="form-select" name="project_id" id="project_id" required>
                            <option value="" selected disabled>- silahkan pilih project -</option>
                            @foreach ($project as $item)
                                <option value="{{ $item->id }}" @selected($item->id == $project_id)>
                                    {{ $item->profile->front_title ?? '' }} {{ $item->profile->name ?? '#' }}
                                    {{ $item->profile->back_title ?? '' }} ({{ $item->periode->name ?? '#' }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary ms-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @if ($kabupaten_dapil != null)
                @foreach ($kabupaten_dapil as $item)
                    <div class="col-md-6 col-xl-3">
                        <a class="block block-rounded block-link-shadow @if ($item->kabupaten_id == $kabupaten_id) bg-success @else bg-primary @endif"
                            href="{{ route('dashboard.index', ['project_id' => $project_id, 'kabupaten_id' => $item->kabupaten_id]) }}"
                            title="Suara: {{ $item->vote }} | Suara Partai: {{ $item->vote_party }}">
                            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="fa fa-2x fa-map text-white-75"></i>
                                </div>
                                <div class="ms-3 text-end">
                                    <p class="text-white fs-3 fw-medium mb-0">
                                        {{ $item->total ?? null }}
                                    </p>
                                    <p class="text-white-75 fw-bolder mb-0">
                                        {{ $item->kabupaten_type ?? null }} {{ $item->kabupaten_name ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="row">
            @if ($kecamatan != null)
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3>Hasil Suara - {{ $kabupaten->type }} {{ $kabupaten->name }}</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <table id="kecamatan_datatable" class="table table-bordered">
                                <thead class="bg-gray">
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Suara</th>
                                        <th>Suara Partai</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kecamatan as $item)
                                        <tr @if ($item->kecamatan_id == $kecamatan_id) class="bg-success" @endif>
                                            <td class="fw-semibold">
                                                <a class="text-dark fw-bolder"
                                                    href="{{ route('dashboard.index', ['project_id' => $project_id, 'kabupaten_id' => $kabupaten_id, 'kecamatan_id' => $item->kecamatan_id]) }}">
                                                    {{ $item->kecamatan_name }}
                                                </a>
                                            </td>
                                            <td>{{ $item->vote }}</td>
                                            <td>{{ $item->vote_party }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            @if ($desa != null)
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3>Hasil Suara - Kecamatan {{ $kecamatan_detail->name }}</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <table id="desa_datatable" class="table table-bordered">
                                <thead class="bg-gray">
                                    <tr>
                                        <th>Desa</th>
                                        <th>Suara</th>
                                        <th>Suara Partai</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($desa as $item)
                                        <tr @if ($item->desa_id == $desa_id) class="bg-success" @endif>
                                            <td class="fw-semibold">
                                                <a class="text-dark fw-bolder"
                                                    href="{{ route('dashboard.index', ['project_id' => $project_id, 'kabupaten_id' => $kabupaten_id, 'kecamatan_id' => $kecamatan_id, 'desa_id' => $item->desa_id]) }}">
                                                    {{ $item->desa_name }}
                                                </a>
                                            </td>
                                            <td>{{ $item->vote }}</td>
                                            <td>{{ $item->vote_party }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            @if ($tps != null)
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3>Hasil Suara - Desa {{ $desa_detail->name }}</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <table id="tps_datatable" class="table table-bordered">
                                <thead class="bg-gray">
                                    <tr>
                                        <th>TPS</th>
                                        <th>Suara</th>
                                        <th>Suara Partai</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tps as $item)
                                        <tr>
                                            <td class="text-dark fw-bolder">
                                                {{ $item->tps_name }}
                                            </td>
                                            <td>{{ $item->vote }}</td>
                                            <td>{{ $item->vote_party }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card" id="kecamatan_chart"></div>
            </div>
        </div>
        <!-- END Dashboard -->
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#kecamatan_datatable').DataTable({
                responsive: true
            });
            $('#desa_datatable').DataTable({
                responsive: true
            });
            $('#tps_datatable').DataTable({
                responsive: true
            });
        });
    </script>
@endsection
