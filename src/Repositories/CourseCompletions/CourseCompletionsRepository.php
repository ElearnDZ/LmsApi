<?php namespace LmsApi\Repositories\CourseCompletions;

use App\User;
use LmsApi\Models\Course;
use LmsApi\Models\CourseCompletion;
use LmsApi\Requests\CourseCompletions;

class CourseCompletionsRepository implements CourseCompletionsInterface
{

  public function index()
  {
    $course_completions = CourseCompletion::with(['user','course'])->get();
    return view('vendor.LmsApi.course_completions.index')
            ->with('course_completions',$course_completions);
  }

  public function create()
  {
    $users = User::all();
    $courses = Course::all();

    return view('vendor.LmsApi.course_completions.create')
            ->with('users',$users)
            ->with('courses',$courses);
  }

  public function store(CourseCompletions\StoreRequest $request)
  {
    $course_completion = CourseCompletion::create($request->all());
    \Session::flash('success','Course Completions is created successfully');
    return redirect('lms\course\completions');
  }

  public function show($id)
  {

  }

  public function edit($id)
  {

  }

  public function update(CourseCompletions\UpdateRequest $request,$id)
  {

  }

  public function destroy($id)
  {

  }

}
