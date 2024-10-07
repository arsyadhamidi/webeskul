<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
        }
    </style>
</head>
<body>

    <h3 style="text-align: center">DATA SISWA</h3>

    <table style="border: 1px solid black; border-collapse: collapse; width: 100%">
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">No.</th>
            <th style="border: 1px solid black">NISN</th>
            <th style="border: 1px solid black">Nama</th>
            <th style="border: 1px solid black">Jurusan</th>
            <th style="border: 1px solid black">Kelas</th>
            <th style="border: 1px solid black">Jekel</th>
        </tr>
        @foreach ($siswas as $data)
            <tr style="border: 1px solid black">
                <td style="border: 1px solid black; text-align: center">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black">{{ $data->nis ?? '-' }}</td>
                <td style="border: 1px solid black">{{ $data->nama ?? '-' }}</td>
                <td style="border: 1px solid black">{{ $data->jurusan->nama_jurusan ?? '-' }}</td>
                <td style="border: 1px solid black">{{ $data->kelas->nama_kelas ?? '-' }}</td>
                <td style="border: 1px solid black">{{ $data->jk ?? '-' }}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
