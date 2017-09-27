<?php namespace LmsApi\Controllers;

use App\Http\Controllers\Controller;
use LmsApi\Repositories\CourseCompletionsCsv\CourseCompletionsCsvInterface;
use LmsApi\Requests\CourseCompletionsCsv;

class CourseCompletionsCsvController extends Controller
{
  private $_course_csv;

  function __construct(CourseCompletionsCsvInterface $course_csv)
  {
    $this->_course_csv = $course_csv;
  }

  public function create()
  {
    return $this->_course_csv->create();
  }

  public function store(CourseCompletionsCsv\StoreRequest $request)
  {
    return $this->_course_csv->store($request);
  }

}
