<?php

namespace Database\Seeders;

use App\Enums\TaskStatus;
use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Todo::factory()->createMany([
        [
          'text' => 'Go for a run in the morning.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Attend the team meeting at work.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Cook dinner for family gathering.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Start learning a new language.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Write a blog post about recent trip.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Clean the house.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Watch the latest movie release.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Complete the weekly report for work.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Buy a gift for friend\'s birthday party.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Plan a surprise anniversary dinner.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Organize files on the computer.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Research vacation destinations.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Go for a hike in the mountains.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Finish knitting the scarf.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Study for upcoming exams.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Attend yoga class.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Pay bills online.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Plant flowers in the garden.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Update resume and LinkedIn profile.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Try out new recipe for dinner.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Read articles on current events.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Practice playing the guitar.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Clean out the refrigerator.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Take the dog for a walk in the park.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Watch a tutorial on coding.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Go shopping for new clothes.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Research investment opportunities.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Visit the local museum.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Plan a day trip to the beach.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Attend a friend\'s birthday celebration.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Sign up for a cooking class.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Practice meditation for stress relief.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Write in the journal before bed.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Attend a live music concert.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Try out new cafe in the neighborhood.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Buy groceries for the week.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Call mom to wish her happy birthday.',
          'status' => TaskStatus::Active
        ],
        [
          'text' => 'Schedule dentist appointment.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Finish reading the book.',
          'status' => TaskStatus::Completed
        ],
        [
          'text' => 'Plan weekend getaway.',
          'status' => TaskStatus::Active
        ]
      ]);
    }
}
