<?php namespace LmsApi\Repositories\CourseCompletionsCsv;

use LmsApi\Requests\CourseCompletionsCsv;
use Excel;
use LmsApi\Traits\CourseCompletionsValidateTrait;
use LmsApi\Commands\CreateCourseCompletions;
use Queue;

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

    $course_completions = $this->courseCompletionsInput($course_completions,$response);

    if(count($course_completions['course_completions_created']) > 0){
      Queue::push(new CreateCourseCompletions($course_completions['course_completions_created']));
    }

    $response =  [
      'course_completions_created' => count($course_completions['course_completions_created']),
      'errors'          => $course_completions['errors'],
    ];

    return redirect()->back()->withErrors($response);
  }
}
