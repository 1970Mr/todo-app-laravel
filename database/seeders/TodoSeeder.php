<?php

namespace Database\Seeders;

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
          'completed' => 0
        ],
        [
          'text' => 'Attend the team meeting at work.',
          'completed' => 1
        ],
        [
          'text' => 'Cook dinner for family gathering.',
          'completed' => 0
        ],
        [
          'text' => 'Start learning a new language.',
          'completed' => 1
        ],
        [
          'text' => 'Write a blog post about recent trip.',
          'completed' => 0
        ],
        [
          'text' => 'Clean the house.',
          'completed' => 1
        ],
        [
          'text' => 'Watch the latest movie release.',
          'completed' => 0
        ],
        [
          'text' => 'Complete the weekly report for work.',
          'completed' => 1
        ],
        [
          'text' => 'Buy a gift for friend\'s birthday party.',
          'completed' => 0
        ],
        [
          'text' => 'Plan a surprise anniversary dinner.',
          'completed' => 1
        ],
        [
          'text' => 'Organize files on the computer.',
          'completed' => 0
        ],
        [
          'text' => 'Research vacation destinations.',
          'completed' => 1
        ],
        [
          'text' => 'Go for a hike in the mountains.',
          'completed' => 0
        ],
        [
          'text' => 'Finish knitting the scarf.',
          'completed' => 1
        ],
        [
          'text' => 'Study for upcoming exams.',
          'completed' => 0
        ],
        [
          'text' => 'Attend yoga class.',
          'completed' => 1
        ],
        [
          'text' => 'Pay bills online.',
          'completed' => 0
        ],
        [
          'text' => 'Plant flowers in the garden.',
          'completed' => 1
        ],
        [
          'text' => 'Update resume and LinkedIn profile.',
          'completed' => 0
        ],
        [
          'text' => 'Try out new recipe for dinner.',
          'completed' => 1
        ],
        [
          'text' => 'Read articles on current events.',
          'completed' => 0
        ],
        [
          'text' => 'Practice playing the guitar.',
          'completed' => 1
        ],
        [
          'text' => 'Clean out the refrigerator.',
          'completed' => 0
        ],
        [
          'text' => 'Take the dog for a walk in the park.',
          'completed' => 1
        ],
        [
          'text' => 'Watch a tutorial on coding.',
          'completed' => 0
        ],
        [
          'text' => 'Go shopping for new clothes.',
          'completed' => 1
        ],
        [
          'text' => 'Research investment opportunities.',
          'completed' => 0
        ],
        [
          'text' => 'Visit the local museum.',
          'completed' => 1
        ],
        [
          'text' => 'Plan a day trip to the beach.',
          'completed' => 0
        ],
        [
          'text' => 'Attend a friend\'s birthday celebration.',
          'completed' => 1
        ],
        [
          'text' => 'Sign up for a cooking class.',
          'completed' => 0
        ],
        [
          'text' => 'Practice meditation for stress relief.',
          'completed' => 1
        ],
        [
          'text' => 'Write in the journal before bed.',
          'completed' => 0
        ],
        [
          'text' => 'Attend a live music concert.',
          'completed' => 1
        ],
        [
          'text' => 'Try out new cafe in the neighborhood.',
          'completed' => 0
        ],
        [
          'text' => 'Buy groceries for the week.',
          'completed' => 1
        ],
        [
          'text' => 'Call mom to wish her happy birthday.',
          'completed' => 0
        ],
        [
          'text' => 'Schedule dentist appointment.',
          'completed' => 1
        ],
        [
          'text' => 'Finish reading the book.',
          'completed' => 1
        ],
        [
          'text' => 'Plan weekend getaway.',
          'completed' => 0
        ]
      ]);
    }
}
