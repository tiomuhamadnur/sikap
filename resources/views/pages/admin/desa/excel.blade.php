<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Desa</title>
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th>desa_id</th>
                    <th>desa_name</th>
                    <th>desa_code</th>
                    <th>kecamatan_id</th>
                    <th>kecamatan_name</th>
                    <th>kecamatan_code</th>
                    <th>kabupaten_id</th>
                    <th>kabupaten_name</th>
                    <th>kabupaten_code</th>
                    <th>provinsi_id</th>
                    <th>provinsi_name</th>
                    <th>provinsi_code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($desa as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->kecamatan->id ?? '' }}</td>
                        <td>{{ $item->kecamatan->name ?? '' }}</td>
                        <td>{{ $item->kecamatan->code ?? '' }}</td>
                        <td>{{ $item->kecamatan->kabupaten->id ?? '' }}</td>
                        <td>{{ $item->kecamatan->kabupaten->type ?? '' }} {{ $item->kecamatan->kabupaten->name ?? '' }}</td>
                        <td>{{ $item->kecamatan->kabupaten->code ?? '' }}</td>
                        <td>{{ $item->kecamatan->kabupaten->provinsi->id ?? '' }}</td>
                        <td>{{ $item->kecamatan->kabupaten->provinsi->name ?? '' }}</td>
                        <td>{{ $item->kecamatan->kabupaten->provinsi->code ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>
