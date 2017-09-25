<?php namespace LmsApi\Repositories\UserApi;

use LmsApi\Requests\UserApi;

interface UserApiInterface
{
  public function getAll();
  public function getDeactivatedUsers();
  public function updateUsers(UserApi\CreateRequest $request);
  public function deleteUsers(UserApi\DeleteRequest $request);
  public function activateUsers(UserApi\ActivateRequest $request);
}
