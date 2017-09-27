<?php namespace LmsApi\Repositories\CourseCompletionsCsv;

use LmsApi\Requests\CourseCompletionsCsv;
use Excel;
use LmsApi\Traits\CourseCompletionsValidateTrait;

class CourseCompletionsCsvRepository implements CourseCompletionsCsvInterface
{
  use CourseCompletionsValidateTrait;

  public function create()
  {
    return view('vendor.LmsApi.create');
  }

  public function store(CourseCompletionsCsv\StoreRequest $request)
  {
    $course_completions_csv = $request->file('csv');

    $course_completions = Excel::load($request->file('csv')->getRealPath(),function($reader){})->get();

    $response = [
      'course_completions_created' => [],
      'errors' => []
    ];

    $response_array = $this->courseCompletionsInput($course_completions,$response);
    if(count($course_compeltions['course_completions_created']) > 0){
      Queue::push(new CreateCourseCompletions($course_compeltions['course_completions_created']));
    }
  }
}
