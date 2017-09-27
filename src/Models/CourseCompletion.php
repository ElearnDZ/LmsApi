<?php namespace LmsApi\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCompletion extends Model
{
  protected $table = 'course_completions';

  protected $fillable = ['course_id','user_id','status','score','issued_certificate','from_timestamp','to_timestamp'];

  protected $dates = ['from_timestamp','to_timestamp'];
  
  public function user()
  {
    return $this->belongsTo('App\user');
  }

  public function course()
  {
    return $this->belongsTo('LmsApi\Models\Course');
  }
}
