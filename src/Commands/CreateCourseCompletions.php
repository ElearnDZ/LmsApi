<?php namespace LmsApi\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use LmsApi\Models\CourseCompletion;

class CreateCourseCompletions extends Command implements SelfHandling {

  private $_courses_input;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($course_completions)
	{
		$this->_course_completions_input = $course_completions;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
    if(!is_array($this->_course_completions_input)) return false;

    foreach($this->_course_completions_input as $course_completion_input){
      $course_completion = CourseCompletion::create($course_completion_input);
    }
    return true;
	}

}
