<?php namespace LmsApi\Repositories\UserApi;

use App\User;
use UMS\Utils\Tree;
use UMS\Models\LevelDetail;
use Request;

class UserApiRepository implements UserApiInterface
{
  private $_tree;
  const SUPERADMIN_DETAIL_ID = 1;
  const SUPERADMIN_LEVEL_ID  = 1;
  public function __construct()
  {
    $this->_tree = new Tree;
  }

  /**
   * [getAll description]
   * @return [type] [description]
   */
  public function getAll()
  {
    $users = User::with('roles','level')->get();
    $users = $this->filters($users);
    return $this->userFields($users);
  }

  /**
   * [getDeactivatedUsers description]
   * @return [type] [description]
   */
  public function getDeactivatedUsers()
  {
    $users =  User::onlyTrashed()->get();
    return $this->userFields($users);
  }

  /**
   * [userFields description]
   * @param  [type] $users [description]
   * @return [type]        [description]
   */
  public function userFields($users)
  {
    $out_users = [];
    foreach($users as $user){
      $user_roles = [];
      foreach($user->roles as $role){
        $user_roles[] = $role->role;
      }
      $out_user = [
        'user_id'             => $user->id,
        'firstname'           => $user->firstname,
        'lastname'            => $user->lastname,
        'login'               => $user->login,
        'email_address'       => $user->email,
        'job_description'     => $user_roles,
        'last_updated_date'   => $user->updated_at->toDateString(),
        'original_start_date' => $user->created_at->toDateString(),
      ];
      $out_user = array_merge($out_user,$this->userLevels($user));
      $out_users[] = $out_user;
    }

    return $out_users;
  }


  public function userLevels(User $user)
  {
    $levels = $this->_tree->getAllParentLevels($user->level);
    $out_levels = [];
    foreach($levels as $level)
    {
      if($level->detail->id != self::SUPERADMIN_DETAIL_ID){
        $out_levels[$level->detail->name] = $level->name;
      }
    }
    return array_reverse($out_levels);
  }

  /**
   * [filters]
   * @param  [type] $users [description]
   * @return [type]        [description]
   */
  public function filters($users)
  {
    $level_details = LevelDetail::all();

    return $users->filter(function($item) use($level_details) {
      $flag   = true;
      $roles  = $item->roles;

      if($roles->contains('id',self::SUPERADMIN_LEVEL_ID)){
        return false;
      }
      if (Request::has('joining_from_date')) {
        $flag = $item->created_at->toDateString() >= Request::get('joining_from_date');
      }

      if ($flag && Request::has('joining_to_date')) {
        $flag = $item->created_at->toDateString() <= Request::get('joining_to_date');
      }

      if ($flag && Request::has('job_description')) {
        $flag   = $roles->contains('role',Request::get('job_description'));        
      }
      if($flag){
        foreach($level_details as $level_detail){
          if($flag && Request::has($level_detail->name)){
            $flag = $item->level->name ===  Request::get($level_detail->name);
          }
        }
      }

      return $flag;
    });



  }

}
