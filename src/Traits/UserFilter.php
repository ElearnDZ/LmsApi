<?php namespace LmsApi\Traits;

use UMS\Models\LevelDetail;
use Request;
use App\User;

trait UserFilter
{
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
      if($user->deleted_at){
        $out_user['leave_date'] = $user->deleted_at->toDateString();
      }
      $out_user = array_merge($out_user,$this->userLevels($user));
      $out_users[] = $out_user;
    }

    return $out_users;
  }

  /**
   * [userLevels description]
   * @param  User   $user [description]
   * @return [type]       [description]
   */
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
          if($flag && Request::has(str_replace(' ','_',$level_detail->name))){
            $flag = $item->level->name ===  Request::get(str_replace(' ','_',$level_detail->name));
          }
        }
      }

      return $flag;
    });
  }

  /**
   * [deactivatedUsersFilter description]
   * @param  [type] $users [description]
   * @return [type]        [description]
   */
  public function deactivatedUsersFilter($users)
  {
    return $users->filter(function($item){
      if(!$item->deleted_at){
        return false;
      }
      $flag = true;
      if(Request::has('from_date')){
        $flag = $item->deleted_at->toDateString() >= Request::get('from_date');
      }

      if(Request::has('to_date')){
        $flag = $item->deleted_at->toDateString() <= Request::get('to_date');
      }

      return $flag;
    });
  }

}
