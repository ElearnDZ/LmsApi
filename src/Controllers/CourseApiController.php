<?php namespace LmsApi\Controllers;

use App\Http\Controllers\Controller;
use LmsApi\Repositories\CourseApi\CourseApiInterface;
use LmsApi\Requests\CourseApi;

class CourseApiController extends Controller
{
  private $_course_api;

  function __construct(CourseApiInterface $course_api)
  {
    $this->_course_api = $course_api;
  }

  public function getAll()
  {
    return $this->_course_api->getAll();
  }

  public function coursesUpdate(CourseApi\UpdateRequest $request)
  {    
    return $this->_course_api->update($request);
  }

}
