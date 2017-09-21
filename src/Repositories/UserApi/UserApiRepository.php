<?php namespace LmsApi\Repositories\UserApi;

use App\User;

class UserApiRepository implements UserApiInterface
{
  public function getAll()
  {
    return User::all();
  }

  public function getDeactivatedUsers()
  {
    return User::onlyTrashed()->get();
  }

}
