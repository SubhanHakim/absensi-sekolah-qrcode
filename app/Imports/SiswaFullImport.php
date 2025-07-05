<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Parents;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaFullImport implements ToModel
{
    public function model(array $row)
    {
        // 1. Cek/insert kelas
        $kelas = SchoolClass::firstOrCreate([
            'class_name' => $row[3],
        ]);

        // 2. Cek/insert orang tua
        $orangtua = Parents::firstOrCreate([
            'nama'   => $row[4],
            'email'  => $row[5],
            'no_hp'  => $row[6],
            'alamat' => $row[7],
        ]);

        // 3. Insert siswa, hubungkan ke kelas dan orang tua
        $siswa = new Student([
            'nama'             => $row[0],
            'nis'              => $row[1],
            'email'            => $row[2],
            'school_class_id'  => $kelas->id,
            'orang_tua_id'     => $orangtua->id,
            'qr_code'          => !empty($row[1]) ? (string)$row[1] : uniqid(),  // fallback jika NIS kosong
        ]);
        $siswa->save();

        // 4. Update parent dengan student_id
        $orangtua->student_id = $siswa->id;
        $orangtua->save();

        return $siswa;
    }
}
