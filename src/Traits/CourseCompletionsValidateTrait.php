<?php namespace LmsApi\Traits;

use LmsApi\Models\CourseCompletion;
use LmsApi\Models\Course;
use App\User;


trait CourseCompletionsValidateTrait
{
  public function validateCourseCompletionsOnUpdate($request)
  {
    $response = [
      'course_compeltions_created' => [],
      'errors' => []
    ];

    if(!$request->has('course_completions')){
      $response['errors'][] = "course_completions is required.";
      return $response;
    }

    $course_completions = json_decode($request->get('course_completions'));
    if(!is_array($course_completions)){
      $response['errors'][] = "course_completions should be an array json string.";
      return $response;
    }

    return $this->courseCompletionsInput($course_completions,$response);
  }

  public function courseCompletionsInput($course_completions,$response)
  {
    $error_line = [];
    $course_completions_in_db = CourseCompletion::all();
    $users_in_db = User::all();
    foreach($course_completions as $course_completion){
      $error = [];

      if(!isset($course_completion->emp_no) && !$course_completion->emp_no){
        $error[] = "emp_no";
      } else {
        if(!$users_in_db->contains('login' , Config::get('efront.LoginPrefix') . $course_completion->emp_no )){
          $error[] = "emp_no is not with us";
        }
      }

      if (!isset($course_compeltion->course_code) && !$course_completion->course_code) {
        $error[]  = "course_code";
      } else {
        if(!$courses->contains('course_code',$course_compeltion->course_code)){
          $error[] = "course_code {$course_compeltion->code} duplicate";
        }
      }

      if (!isset($course_completion->status) && !$course_completion->status) {
        $error[] = "status";
      }

      if (!isset($course_completion->issued_certificate) && !$course_completion->issued_certificate) {
        $error[] = "issued_certificate";
      }

      if (!isset($course_completion->score) && !$course_completion->score) {
        $error[] = "score";
      }

      if (!isset($course_completion->from_timestamp) && !$course_completion->from_timestamp) {
        $error[] = "from_timestamp";
      }else{
        
      }

      if (!isset($course_completion->to_timestamp) && !$course_completion->to_timestamp) {
        $error[] = "to_timestamp";
      }

    }
  }
}
