<?php
namespace Database\Factories;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'user_id' => User::factory(), // atau User::factory() jika ingin relasi ke user
            'school_class_id' => SchoolClass::factory(),
            'nis' => $this->faker->unique()->numerify('NIS#####'),
            'qr_code' => $this->faker->unique()->numerify('QR#####'),
        ];
    }
}