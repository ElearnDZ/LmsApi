<?php namespace LmsApi\Repositories\CourseApi;

use LmsApi\Models\Course;
use LmsApi\Traits\CoursesValidate;
use LmsApi\Traits\ApiLogTrait;

use LmsApi\Requests\CourseApi;
use LmsApi\Commands\CreateCourses;
use LmsApi\Commands\UpdateCourses;
use Queue;

class CourseApiRepository implements CourseApiInterface
{
  use CoursesValidate,ApiLogTrait;

  public function getAll()
  {
    $courses = Course::select(['course_code','course_name','efront_course_id'])->get();
    return $courses;
  }

  public function update(CourseApi\UpdateRequest $request)
  {
    $courses = $this->validateOnUpdate($request);

    if(count($courses['courses_created']) > 0){
      Queue::push(new CreateCourses($courses['courses_created']));
    }
    if(count($courses['courses_updated']) > 0){
      Queue::push(new UpdateCourses($courses['courses_updated']));
    }
    $response =  [
      'courses_created' => count($courses['courses_created']),
      'courses_updated' => count($courses['courses_updated']),
      'errors'          => $courses['errors'],
    ];
    $this->apiLog($request,$response);
    return $response;
  }
}
