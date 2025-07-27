<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class AbsensiTelatTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_absen_sebelum_jam_7_status_hadir()
    {
        $user = User::factory()->create();
        $user->assignRole('petugas');
        $class = SchoolClass::factory()->create();
        $student = Student::factory()->create([
            'school_class_id' => $class->id,
            'qr_code' => '12345'
        ]);

        $this->actingAs($user);

        Carbon::setTestNow(Carbon::createFromTime(6, 59, 0)); // 06:59

        $response = $this->post(route('dashboard.petugas.process-absen'), [
            'qr_code' => '12345',
        ]);

        $response->dump();
        $response->dumpSession(); // tambahkan ini untuk debug

        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'status' => 'hadir',
        ]);
    }

    public function test_siswa_absen_setelah_jam_7_status_telat()
    {
        $user = User::factory()->create();
        $class = SchoolClass::factory()->create();
        $student = Student::factory()->create(['school_class_id' => $class->id, 'qr_code' => '54321']);

        $this->actingAs($user);

        Carbon::setTestNow(Carbon::createFromTime(7, 1, 0)); // 07:01

        $response = $this->post(route('dashboard.petugas.process-absen'), [
            'qr_code' => '54321',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'status' => 'telat',
        ]);
    }
}
