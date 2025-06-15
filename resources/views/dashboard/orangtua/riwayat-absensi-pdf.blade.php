{{-- filepath: resources/views/dashboard/orangtua/riwayat-absensi-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Absensi Anak</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #888; padding: 6px 8px; }
        th { background: #2563eb; color: #fff; }
        tr:nth-child(even) { background: #f1f5f9; }
    </style>
</head>
<body>
    <h2>Riwayat Absensi Anak</h2>
    <p><strong>Nama:</strong> {{ $student->nama }}</p>
    <p><strong>NIS:</strong> {{ $student->nis }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $absen)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($absen->status) }}</td>
                    <td>{{ $absen->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>