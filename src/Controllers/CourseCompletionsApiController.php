<?php namespace LmsApi\Controllers;

use App\Http\Controllers\Controller;
use LmsApi\Repositories\CourseCompletionsApi\CourseCompletionsApiInterface;
use LmsApi\Requests\CourseCompletionsApi;

class CourseCompletionsApiController extends Controller
{
  private $_course_completions_api;

  function __construct(CourseCompletionsApiInterface $course_completions_api)
  {
    $this->_course_completions_api = $course_completions_api;
  }

  public function getAll()
  {
    return $this->_course_completions_api->getAll();
  }

  public function coursesUpdate(CourseCompletionsApi\UpdateRequest $request)
  {
    return $this->_course_completions_api->update($request);
  }

}
