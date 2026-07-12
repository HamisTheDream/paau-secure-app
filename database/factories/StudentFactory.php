<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        
        // Weighting the array so most students have 'None'
        $securityStatuses = ['None', 'None', 'None', 'None', 'None', 'Wanted', 'Investigated', 'Suspended', 'Withdrawn'];

        return [
            'name' => $name,
            'matric_number' => 'PAAU/' . fake()->randomElement(['CSC', 'LAW', 'ACC', 'BCH', 'MCB']) . '/' . fake()->numberBetween(2019, 2026) . '/' . fake()->unique()->numerify('###'),
            'department' => fake()->randomElement(['Computer Science', 'Law', 'Accounting', 'Biochemistry', 'Microbiology']),
            'level' => fake()->randomElement(['100L', '200L', '300L', '400L', '500L']),
            'phone_number' => fake()->phoneNumber(),
            'dob' => fake()->dateTimeBetween('-30 years', '-16 years')->format('Y-m-d'),
            'fees_status' => fake()->randomElement(['Paid', 'Unpaid', 'Partial']),
            'security_status' => fake()->randomElement($securityStatuses),
            // Generates a nice image with the student's initials
            'profile_picture' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&size=200'
        ];
    }
}
