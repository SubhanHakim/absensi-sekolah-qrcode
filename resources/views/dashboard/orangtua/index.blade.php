{{-- filepath: resources/views/dashboard/siswa/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h1>Dashboard Siswa</h1>
<p>Selamat datang, {{ auth()->user()->name }}!</p>
<ul>
    <li><a href="#">Lihat Riwayat Absensi</a></li>
    <li><a href="#">Status Kehadiran Hari Ini</a></li>
</ul>
@endsection