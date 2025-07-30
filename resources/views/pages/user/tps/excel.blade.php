<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>TPS</title>
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>address</th>
                    <th>desa</th>
                    <th>kecamatan</th>
                    <th>kabupaten</th>
                    <th>provinsi</th>
                    <th>dapil</th>
                    <th>profil</th>
                    <th>tipe pemilihan</th>
                    <th>periode</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tps as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->desa->name ?? '' }}</td>
                        <td>{{ $item->desa->kecamatan->name ?? '' }}</td>
                        <td>{{ $item->desa->kecamatan->kabupaten->type ?? '' }} {{ $item->desa->kecamatan->kabupaten->name ?? '' }}</td>
                        <td>{{ $item->desa->kecamatan->kabupaten->provinsi->name ?? '' }}</td>
                        <td>{{ $item->dapil->name ?? '' }}</td>
                        <td>{{ $item->dapil->project->profile->name ?? '' }}</td>
                        <td>{{ $item->dapil->project->election_type->name ?? '' }}</td>
                        <td>{{ $item->dapil->project->periode->name ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>
