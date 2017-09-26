<?php namespace LmsApi\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use LmsApi\Models\Course;

class UpdateCourses extends Command implements SelfHandling {

  private $_courses_input;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($courses)
	{
		$this->_courses_input = $courses;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
    if(!is_array($this->_courses_input)) return false;

    foreach($this->_courses_input as $course_input){
      $course = Course::where('course_code',$course_input['course_code'])->first();
      if($course){
        $course->course_name = $course_input['course_name'];
        $course->efront_course_id = $course_input['efront_course_id'];
        $course->save();
      }
    }
    return true;
	}

}
