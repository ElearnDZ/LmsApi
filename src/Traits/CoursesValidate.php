<?php namespace LmsApi\Traits;

use LmsApi\Models\Course;

trait CoursesValidate
{
  public function validateOnUpdate($request)
  {
    $result = [
      'courses_created' => [],
      'courses_updated'  => [],
      'errors'           => []
    ];

    if(!$request->has('courses')){
      $result['errors'][] = 'courses is required.';
      return $result;
    }
    $courses = $request->courses;
    $courses = json_decode($courses);
    if(!is_array($courses)){
      $result['errors'][] = 'courses should be json array of courses.';
      return $result;
    }

    return $this->validateCourseDetails($result,$courses);

  }

  public function validateCourseDetails($result,$courses)
  {
    $courses_in_db = Course::all();
    $courses_updated = collect([]);
    $courses_created = collect([]);
    foreach ($courses as $key =>  $course) {
      $error = [];
      if(!isset($course->course_name) || !$course->course_name ){
        $error[] = 'course_name' ;
      }

      if(!isset($course->course_code) || !$course->course_code || !ctype_alnum($course->course_code)){
        $error[] = 'course_code' ;
      }else{
        if($courses_created->contains('course_code',$course->course_code)){
          $error[] = 'course_code duplicate';
        }

        if($courses_updated->contains('course_code',$course->course_code)){
          $error[] = 'course_code duplicate';
        }
      }

      if(!isset($course->efront_course_id) || !$course->efront_course_id || !is_numeric($course->efront_course_id)){
        $error[] = 'efront_course_id' ;
      }

      if(count($error) > 0){
        $result['errors'][] = "line ". ($key + 1).",has error in ".implode(",",$error);
      } else {
        if($courses_in_db->contains('course_code',$course->course_code)){
        $courses_updated->push([
            'course_name' => $course->course_name,
            'course_code' => $course->course_code,
            'efront_course_id' => $course->efront_course_id,
          ]);
        }else{
          $courses_created->push([
            'course_name' => $course->course_name,
            'course_code' => $course->course_code,
            'efront_course_id' => $course->efront_course_id,
          ]);
        }
      }
    }
    $result['courses_updated'] = $courses_updated->toArray();
    $result['courses_created'] = $courses_created->toArray();
    return $result;
  }
}
