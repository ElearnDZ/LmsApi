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
    $course_completion = CourseCompletion::with(['course','user'])->findOrFail($id);
    $users = User::all();
    $courses = Course::all();

    return view('vendor.LmsApi.course_completions.edit')
            ->with('course_completion',$course_completion)
            ->with('users',$users)
            ->with('courses',$courses);
  }

  public function update(CourseCompletions\UpdateRequest $request,$id)
  {
    $input = $request->all();
    $course_completion = CourseCompletion::findOrFail($id);
    $course_completion->user_id = $input['user_id'];
    $course_completion->course_id = $input['course_id'];
    $course_completion->status = $input['status'];
    $course_completion->score = $input['score'];
    $course_completion->issued_certificate = $input['issued_certificate'];
    $course_completion->from_timestamp = $input['from_timestamp'];
    $course_completion->to_timestamp = $input['to_timestamp'];
    $course_completion->save();
    \Session::flash('success','Course Completions updated successfully');
    return redirect('lms\course\completions');
  }

  public function destroy($id)
  {
      $course_completion = CourseCompletion::findOrFail($id);
      $course_completion->delete();
      \Session::flash('success','Course Completions deleted successfully');
      return redirect('lms\course\completions');
  }

}
