<?php namespace LmsApi\Traits;

use LmsApi\Models\CourseCompletion;
use LmsApi\Models\Course;
use App\User;
use Config;

trait CourseCompletionsValidateTrait
{
  public function validateCourseCompletionsOnUpdate($request)
  {
    $response = [
      'course_completions_created' => [],
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

    $error_line               = [];
    $course_completions_in_db = CourseCompletion::all();
    $users_in_db              = User::all();
    $courses                  = Course::all();
    $course_completions_created = collect([]);

    foreach($course_completions as $key => $course_completion){
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
        if(!$courses->contains('course_code',$course_completion->course_code)){
          $error[] = "course_code {$course_compeltion->code} not with us";
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

      if (!isset($course_completion->from_timestamp) && !$course_completion->from_timestamp && checkdate($course_completion->from_timestamp)) {
        $error[] = "from_timestamp";
      }

      if (!isset($course_completion->to_timestamp) && !$course_completion->to_timestamp && checkdate($course_completion->to_timestamp)) {
        $error[] = "to_timestamp";
      }

      if(!$error){
        $course_completion_unique = $course_completions_created->filter(function($item) use($course_completion) {
          return ($course_completion->course_code === $item['course_code']) && ($course_completion->emp_no === $item['emp_no']);
        })->first();
        if($course_completion_unique){
          $error[] = "duplicate record";
        }

        $course_completion_db_duplicate = $course_completions_in_db->filter(function($item) use($course_completion) {
          return ($course_completion->course_code === $item->course->course_code) && ($course_completion->emp_no === (Config::get('efront.LoginPrefix').$item->user->login));
        })->first();
        if($course_completion_db_duplicate){
          $error[] = "duplicate record in db";
        }
      }

      if($error){
        $error_line[] = "line ". ($key + 1).",has error in ".implode(",",$error);
      }else{

        $user = $users_in_db->filter(function($item) use($course_completion) {
          return ($item->login === (Config::get('efront.LoginPrefix') . $course_completion->emp_no));
        })->first();

        $course = $courses->filter(function($item) use($course_completion) {
          return $item->course_code === $course_completion->course_code;
        })->first();

        $out_array  = [
          'user_id'             => $user->id,
          'course_id'           => $course->id,
          'course_code'         => $course_completion->course_code,
          'emp_no'              => $course_completion->emp_no,
          'status'              => $course_completion->status,
          'score'               => $course_completion->score,
          'issued_certificate'  => $course_completion->issued_certificate,
          'from_timestamp'      => date('Y-m-d H:i:s',strtotime($course_completion->from_timestamp)),
          'to_timestamp'        => date('Y-m-d H:i:s',strtotime($course_completion->to_timestamp)),
        ];

        $course_completions_created->push($out_array);
      }
    }
    
    return [
      'course_completions_created' => $course_completions_created->toArray(),
      'errors' => $error_line
    ];
  }
}
