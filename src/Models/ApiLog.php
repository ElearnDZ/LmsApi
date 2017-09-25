<?php namespace LmsApi\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
  protected $table = 'api_logs';
  protected $fillable = ['api_request_route','api_request_type','api_input','result_message'];
  public $timestamps = false;

	protected $dates = ['created_at'];

	public static function boot()
  {
      parent::boot();

      static::creating(function ($model) {
          $model->created_at = $model->freshTimestamp();
      });
  }
}
