<?php

namespace Tests\Functional\Api;

use App\Course;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\Helpers\Functional;
use Tests\Helpers\TestConstants;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    /**
     * Courses endpoint.
     *
     * @var string
     */
    protected $coursesEndpoint = 'api/courses';

    /**
     * Single course endpoint.
     */
    protected $singleCourseEndpoint = 'api/courses/{courseId}';

    /**
     * Course resource structure.
     *
     * @var array
     */
    protected $courseResourceStructure = [
        'slug',
        'title',
        'description',
        'image',
        'difficulty',
        'duration',
        'students',
        'free',
    ];

    /**
     * Test get courses ok.
     */
    public function testGetCoursesOk()
    {
        // Config
        $numberOfCoursesPublished = 7;
        $numberOfCoursesDraft = 4;
        $numberOfChapters = 5;
        $numberOfLessons = 7;

        // Prepare
        $teacher = factory(User::class)->create();
        $this->createCoursesWithChaptersAndLessons($teacher, $numberOfCoursesPublished, $numberOfChapters, $numberOfLessons);
        $this->createCoursesWithChaptersAndLessons($teacher, $numberOfCoursesDraft, $numberOfChapters, $numberOfLessons, ['status' => 'draft']);

        // Request
        $response = $this->call('get', $this->coursesEndpoint);

        // Asserts
        $response->assertStatus(200);
        $response->assertApiResponseResourceCountIs($numberOfCoursesPublished);
        $response->assertApiResponseResourceStructureIs(TestConstants::RESOURCE_TYPE_COURSE, $this->courseResourceStructure);
    }

    /**
     * Test get single course ok.
     */
    public function testGetSingleCourseOk()
    {
        // Prepare
        $teacher = factory(User::class)->create();
        $courses = $this->createCoursesWithChaptersAndLessons($teacher);
        $course = $courses->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseEndpoint, ['courseId' => $course->id]));

        // Asserts
        $response->assertStatus(200);
        $response->assertApiResponseResourceStructureIs(TestConstants::RESOURCE_TYPE_COURSE, $this->courseResourceStructure);
    }

    /**
     * Test get single course that does not exist throws a not found error.
     */
    public function testGetSingleCourseErrorNotFound()
    {
        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseEndpoint, ['courseId' => '123123']));

        // Asserts
        $response->assertResponseIsErrorApiResponse(404, 1);
    }

    /**
     * Populate the database with courses, chapters and lessons.
     *
     * @param User $teacher
     * @param integer $numberOfCourses
     * @param integer $numberOfChapters
     * @param integer $numberOfLessons
     * @param array $courseAttributes
     *
     * @return Collection
     */
    private function createCoursesWithChaptersAndLessons(User $teacher, $numberOfCourses = 1, $numberOfChapters = 1, $numberOfLessons = 1, $courseAttributes = [])
    {
        $courseAttributes = array_merge(['difficulty' => 'beginner' , 'status' => 'published'], $courseAttributes);
        $faker = \Faker\Factory::create();
        $courses = new Collection();
        for ($i = 1; $i <= $numberOfCourses; $i++) {
            $course = factory(Course::class)->create([
                'teacher_id' => $teacher->id,
                'slug' => $faker->slug,
                'title' => $faker->text,
                'description' => $faker->text,
                'image' => $faker->url,
                'difficulty' => $courseAttributes['difficulty'],
                'duration' => 100,
                'students' => 50,
                'free' => false,
                'status' => $courseAttributes['status'],
            ]);
            /*for ($numChapters = 1; $numChapters <= $numberOfChapters; $numChapters++) {
                $chapter = factory(Chapter::class)->create([]);
                for ($numLessons = 1; $numLessons <= $numberOfLessons; $numLessons++) {
                    $lesson = factory(Lesson::class)->create([]);
                }
            }*/
            $courses->add($course);
        }

        return $courses;
    }
}
