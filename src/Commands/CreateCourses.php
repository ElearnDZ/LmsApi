<?php namespace LmsApi\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use LmsApi\Models\Course;

class CreateCourses extends Command implements SelfHandling {

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
      $course = Course::create($course_input);
    }
    return true;
	}

}
