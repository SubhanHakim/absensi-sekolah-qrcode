<!DOCTYPE html>
<html>
<head>
    <title>QR Code Siswa</title>
    <style>
        body { font-family: sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h2>QR Code Siswa</h2>
    <p>{{ $student->nama }}<br>NIS: {{ $student->nis }}</p>
    <div>
        <img src="{{ public_path('storage/'.$student->qr_code_path) }}" width="200">
    </div>
</body>
</html>