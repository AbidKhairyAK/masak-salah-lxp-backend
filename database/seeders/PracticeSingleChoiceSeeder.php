<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Practice;
use App\Models\PracticeSingleChoiceOption;
use App\Models\PracticeSingleChoiceQuestion;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PracticeSingleChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapter = Chapter::first();

        $topic = Topic::create([
            'chapter_id' => $chapter->id,
            'title' => "Topic in " . $chapter->title,
            'sort_order' => 0,
            'type' => 'practice'
        ]);

        $practice = Practice::create([
                'topic_id' => $topic->id,
                'type' => 'single_choice',
        ]);


        // Seed PracticeSingleChoiceQuestions and PracticeSingleChoiceOptions
        $questions = [
            [
                'question' => 'What is the capital of France?',
                'image' => 'https://wallpapers.com/images/hd/kaneki-sad-v0i7i13o2olr8hpw.jpg',
                'options' => [
                    ['description' => 'Berlin', 'is_correct' => false],
                    ['description' => 'Madrid', 'is_correct' => false],
                    ['description' => 'Paris', 'is_correct' => true],
                    ['description' => 'Rome', 'is_correct' => false],
                ]
            ],
            [
                'question' => 'What is 2 + 2?',
                'image' => null,
                'options' => [
                    ['description' => '3', 'is_correct' => false],
                    ['description' => '4', 'is_correct' => true],
                    ['description' => '5', 'is_correct' => false],
                    ['description' => '6', 'is_correct' => false],
                ]
            ],
            [
                'question' => 'What is the largest ocean on Earth?',
                'image' => null,
                'options' => [
                    ['description' => 'Atlantic Ocean', 'is_correct' => false],
                    ['description' => 'Indian Ocean', 'is_correct' => false],
                    ['description' => 'Arctic Ocean', 'is_correct' => false],
                    ['description' => 'Pacific Ocean', 'is_correct' => true],
                ]
            ]
        ];

        // Loop through each question and create it
        foreach ($questions as $questionData) {
            // Create the question
            $question = PracticeSingleChoiceQuestion::create([
                'practice_id' => $practice->id,
                'question' => $questionData['question'],
            ]);

            if ($questionData['image']) {
                $question->addMediaFromUrl($questionData['image'])->toMediaCollection('image');
            }

            // Create the options for the question
            foreach ($questionData['options'] as $optionData) {
                PracticeSingleChoiceOption::create([
                    'question_id' => $question->id,
                    'description' => $optionData['description'],
                    'is_correct' => $optionData['is_correct'],
                ]);
            }
        }
    }
}
