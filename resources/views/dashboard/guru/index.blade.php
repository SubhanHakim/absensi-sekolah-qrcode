{{-- filepath: resources/views/dashboard/guru/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h1>Dashboard Guru</h1>
<p>Selamat datang, {{ auth()->user()->name }}!</p>
<ul>
    <li><a href="#">Lihat Daftar Siswa</a></li>
    <li><a href="#">Absensi Siswa (Scan QR)</a></li>
    <li><a href="#">Rekap Absensi</a></li>
</ul>
@endsection