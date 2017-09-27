<?php namespace LmsApi\Repositories\CourseCompletionsApi;

use LmsApi\Models\CourseCompletion;

use LmsApi\Traits\CourseCompletionsValidateTrait;
use LmsApi\Traits\CourseCompletionsFilterTrait;
use LmsApi\Traits\ApiLogTrait;
use LmsApi\Traits\UserFilter;

use LmsApi\Requests\CourseCompletionsApi;
use LmsApi\Commands\CreateCourseCompletions;
use LmsApi\Commands\UpdateCourseCompletions;
use Queue;
use UMS\Utils\Tree;

class CourseCompletionsApiRepository implements CourseCompletionsApiInterface
{
  use ApiLogTrait,CourseCompletionsFilterTrait,UserFilter,CourseCompletionsValidateTrait;

  private $_tree;
  const SUPERADMIN_DETAIL_ID = 1;
  const SUPERADMIN_LEVEL_ID  = 1;
  const STUDENT_ROLE_ID      = 3;

  public function __construct()
  {
    $this->_tree = new Tree;
  }

  public function getAll()
  {
    $course_completions = CourseCompletion::with(['user','course'])->get();
    return $this->courseCompletionsFilter($course_completions);
  }

  public function update(CourseCompletionsApi\UpdateRequest $request)
  {
    $course_completions = $this->validateCourseCompletionsOnUpdate($request);

    if(count($course_completions['course_completions_created']) > 0){
      Queue::push(new CreateCourseCompletions($course_completions['course_completions_created']));
    }
    $response =  [
      'course_completions_created' => count($course_completions['course_completions_created']),
      'errors'          => $course_completions['errors'],
    ];
    $this->apiLog($request,$response);
    return $response;
  }
}
