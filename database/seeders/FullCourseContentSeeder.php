<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonArticle;
use App\Models\LessonPdf;
use App\Models\LessonVideo;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FullCourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            for ($i = 1; $i <= 2; $i++) {
                $chapter = Chapter::create([
                    'course_id' => $course->id,
                    'title' => "Chapter $i for " . $course->title,
                ]);

                for ($j = 1; $j <= 2; $j++) {
                    $topic = Topic::create([
                        'chapter_id' => $chapter->id,
                        'title' => "Topic $j in " . $chapter->title,
                        'sort_order' => $j,
                        'type' => 'lesson'
                    ]);

                    // for ($k = 1; $k <= 2; $k++) {
                    $lessonTypes = ['pdf', 'video', 'article'];

                    $lessonType = $lessonTypes[array_rand($lessonTypes)];

                    $lesson = Lesson::create([
                        'topic_id' => $topic->id,
                        'type' => $lessonType,
                    ]);

                    $faker = Faker::create('id_ID');

                    if ($lessonType ===  'video') {
                        LessonVideo::create([
                            'lesson_id' => $lesson->id,
                            'video_url' => 'https://www.youtube.com/embed/_zI4bT14Sl4?si=s872f8NoU_7xmL2b',
                        ]);
                    } elseif ($lessonType === 'pdf') {
                        LessonPdf::create([
                            'lesson_id' => $lesson->id,
                            'pdf_url' => 'https://pdfobject.com/pdf/sample.pdf',
                        ]);
                    } else {
                        LessonArticle::create([
                            'lesson_id' => $lesson->id,
                            // 'content' => $faker->randomHtml(),
                            'content' => "<h3>Typography should be easy</h3> <p>So that's a header for you — with any luck if we've done our job correctly that will look pretty reasonable.</p> <p>Something a wise person once told me about typography is:</p> <blockquote><p>Typography is pretty important if you don't want your stuff to look like trash. Make it good then it won't be bad.</p></blockquote> <p>It's probably important that images look okay here by default as well:</p> <figure> <img src='https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80' alt='' /> <figcaption>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</figcaption> </figure>"
                        ]);
                    }
                }
            }
        }
    }
}
