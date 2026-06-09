<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\LMS\Models\Auth\Student;
use Modules\LMS\Models\User;

/**
 * Creates a ready-to-use, PRE-APPROVED test student so the client can log in
 * and test the student dashboard immediately:
 *   email: student@gmail.com   password: 123456
 *
 * Real students who self-register still come in as is_verify = 0 (pending) and
 * must be approved by the owner before they can log in — this seeder only makes
 * one approved account for testing. Idempotent (safe to re-run).
 */
class TestStudentSeeder extends Seeder
{
    public function run(): void
    {
        $student = Student::updateOrCreate(
            ['first_name' => 'Test', 'last_name' => 'Student'],
            [
                'first_name' => 'Test',
                'last_name'  => 'Student',
                'phone'      => '0400000099',
                'status'     => 1,
            ]
        );

        $user = User::where('email', 'student@gmail.com')->first();

        if (! $user) {
            // Same creation path the registration repository uses, but approved.
            $user = $student->user()->create([
                'email'     => 'student@gmail.com',
                'password'  => Hash::make('123456'),
                'guard'     => 'student',
                'username'  => 'test-student',
                'is_verify' => 1,
            ]);
        } else {
            $user->update([
                'userable_type' => Student::class,
                'userable_id'   => $student->id,
                'guard'         => 'student',
                'password'      => Hash::make('123456'),
                'is_verify'     => 1,
            ]);
        }

        if (! $user->hasRole('Student')) {
            $user->assignRole('Student');
        }
    }
}
