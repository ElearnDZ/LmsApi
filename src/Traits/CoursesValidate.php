<?php namespace LmsApi\Traits;

use LmsApi\Models\Course;

trait CoursesValidate
{
  /**
   * [validateOnUpdate description]
   * @param  [type] $request [description]
   * @return [type]          [description]
   */
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

  /**
   * [validateCourseDetails description]
   * @param  [type] $result  [description]
   * @param  [type] $courses [description]
   * @return [type]          [description]
   */
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

      if(count($error) > 0){
        $result['errors'][] = "line ". ($key + 1).",has error in ".implode(",",$error);
      } else {
        $course_out_array = [
          'course_name' => filter_var($course->course_name, FILTER_SANITIZE_STRING),
          'course_code' => filter_var($course->course_code, FILTER_SANITIZE_STRING),
          'efront_course_id' => isset($course->efront_course_id)?$course->efront_course_id:0,
        ];
        if($courses_in_db->contains('course_code',$course->course_code)){
          $courses_updated->push($course_out_array);
        }else{
          $courses_created->push($course_out_array);
        }
      }
    }
    $result['courses_updated'] = $courses_updated->toArray();
    $result['courses_created'] = $courses_created->toArray();
    return $result;
  }
}
