<?php namespace LmsApi\Requests\CourseCompletions;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'user_id' => 'required|exists:users,id',
      'course_id' => 'required|exists:courses,id',
      'status'  => 'required|max:255',
      'score'   => 'required|max:255',
      'issued_certificate' => 'required|max:255',
      'from_timestamp' => 'required|date_format:Y-m-d H:i:s,before:date()',
      'to_timestamp' => 'required|date_format:Y-m-d H:i:s,before:date()',
    ];
  }

  public function messages()
  {
    return [
      'user_id.required' => 'Please Select the user from the list.',
      'user_id.exists' => 'Please Select the user from the list.',
      'course_id.required' => 'Please Select the course from the list.',
      'course_id.exists' => 'Please Select the course from the list.',
    ];
  }
}
