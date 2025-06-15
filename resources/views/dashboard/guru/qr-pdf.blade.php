<!DOCTYPE html>
<html>
<head>
    <title>QR Code Siswa Kelas {{ $kelas->class_name }}</title>
    <style>
        body { font-family: sans-serif; }
        .qr { display: inline-block; margin: 10px; text-align: center; }
    </style>
</head>
<body>
    <h2>QR Code Siswa Kelas {{ $kelas->class_name }}</h2>
    @foreach($students as $student)
        <div class="qr">
            <div>
                {!! QrCode::size(100)->generate($student->qr_code) !!}
            </div>
            <div>{{ $student->nama }}<br>NIS: {{ $student->nis }}</div>
        </div>
    @endforeach
</body>
</html>