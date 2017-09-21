<?php namespace LmsApi\Repositories\UserApi;

interface UserApiInterface
{
  public function getAll();
  public function getDeactivatedUsers();
}
