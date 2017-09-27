<?php namespace LmsApi\Traits;
use Request;
use UMS\Models\LevelDetail;
use LmsApi\Traits\UserFilter;

trait CourseCompletionsFilterTrait
{  

  public function courseCompletionsFilter($course_completions)
  {
    $level_details = LevelDetail::all();

    $course_completions =  $course_completions->filter(function($item) use($level_details){

      $flag = true;
      if($flag && Request::has('completed_from_date')){
        $flag = ($item->to_timestamp->toDateString() >= Request::get("completed_from_date")) ? true : false;
      }
      if($flag && Request::has('completed_to_date')){
        $flag = ($item->to_timestamp->toDateString() <= Request::get("completed_to_date")) ? true : false;
      }

      if($flag){
        foreach($level_details as $level_detail){
          if($flag && Request::has($level_detail->name)){
            $user = $item->user;
            $flag = $user->level->name ===  Request::get($level_detail->name);
          }
        }
      }

      if ($flag && Request::has('job_description')) {
        $user  = $item->user;
        $roles = $user->roles;
        $flag  = $roles->contains('role',Request::get('job_description'));
      }

      return $flag;
    });

    return $this->courseCompletionsFields($course_completions);

  }

  public function courseCompletionsFields($course_completions)
  {
    $course_completions_out_array = [];
    foreach($course_completions as $course_completion){
      $user_roles = [];
      $user  = $course_completion->user;
      foreach($user->roles as $role){
        $user_roles[] = $role->role;
      }
      $out_array = [
        'emp_no'   => $course_completion->user->login,
        'forename' => $course_completion->user->firstname,
        'surname'  => $course_completion->user->lastname,
        'job_description' => $user_roles,
        'course_name' => $course_completion->course->course_name,
        'course_code' => $course_completion->course->course_code,
        'from_date'   => $course_completion->from_timestamp->toDateString(),
        'to_date'     => $course_completion->to_timestamp->toDateString(),
        'status'      => $course_completion->status,
        'score'       => $course_completion->score,
        'issued_certificate' => $course_completion->issued_certificate,
      ];
      $out_array = array_merge($out_array,$this->userLevels($user));
      $course_completions_out_array[] = $out_array;

    }

    return collect($course_completions_out_array);

  }
}
