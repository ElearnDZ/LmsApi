<?php namespace LmsApi\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $table = 'courses';

  protected $fillable = ['course_name','course_code','efront_course_id'];
  
}
