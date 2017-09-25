<?php namespace LmsApi\Traits;

use LmsApi\Models\ApiLog;

trait UserApiLog
{
  function updateLog($request,$result)
  {
    ApiLog::create([
      'api_request_route' => $request->url(),
      'api_request_type'  => $request->method(),
      'api_input'         => json_encode($request->all()),
      'result_message'    => json_encode($result)
    ]);
  }
}
