<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        
        $securityStatuses = ['None', 'None', 'None', 'None', 'None', 'Wanted', 'Investigated', 'Suspended'];

        return [
            'name' => $name,
            'staff_number' => 'PAAU/STF/' . fake()->unique()->numerify('####'),
            'role' => fake()->randomElement(['Lecturer', 'Security Officer', 'Admin Staff', 'Bursar', 'Technician']),
            'rank' => fake()->randomElement(['Professor', 'Senior Lecturer', 'Lecturer I', 'Assistant', 'Non-Academic']),
            'department' => fake()->randomElement(['Computer Science', 'Security Unit', 'Registry', 'Bursary', 'Law']),
            'phone_number' => fake()->phoneNumber(),
            'dob' => fake()->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),
            'security_status' => fake()->randomElement($securityStatuses),
            'profile_picture' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&size=200'
        ];
    }
}
