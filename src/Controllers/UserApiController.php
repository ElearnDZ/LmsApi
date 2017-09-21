<?php namespace LmsApi\Controllers;

use App\Http\Controllers\Controller;
use LmsApi\Repositories\UserApi\UserApiInterface;

class UserApiController extends Controller
{
  private $_user_api;

  function __construct(UserApiInterface $user_api)
  {
    $this->_user_api = $user_api;
  }

  public function getAll()
  {
    return $this->_user_api->getAll();
  }

  public function getDeactivatedUsers()
  {
    return $this->_user_api->getDeactivatedUsers();
  }
}
