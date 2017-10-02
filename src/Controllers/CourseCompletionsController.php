<?php namespace LmsApi\Controllers;

use App\Http\Controllers\Controller;
use LmsApi\Repositories\CourseCompletions\CourseCompletionsInterface;
use LmsApi\Requests\CourseCompletions;

class CourseCompletionsController extends Controller
{
  private $_course_completions;

  function __construct(CourseCompletionsInterface $course_completions)
  {
    $this->_course_completions = $course_completions;
  }

  public function index()
  {    
    return $this->_course_completions->index();
  }

  public function show($id)
  {
    return $this->_course_completions->show($id);
  }

  public function create()
  {
    return $this->_course_completions->create();
  }

  public function store(CourseCompletions\StoreRequest $request)
  {
    return $this->_course_completions->store($request);
  }

  public function edit($id)
  {
    return $this->_course_completions->edit($id);
  }

  public function update(CourseCompletions\UpdateRequest $request,$id)
  {
    return $this->_course_completions->update($request,$id);
  }

  public function destroy($id)
  {
    return $this->_course_completions->destroy($id);
  }
}
