<?php namespace LmsApi\Traits;
use UMS\Models\LevelDetail;
use App\User;
use DB;
trait UsersValidate
{

  /**
   * [deleteUsersApiValidate description]
   * @param  [type] $request [description]
   * @return [type]          [description]
   */
   public function deleteUsersApiValidate($request)
   {
     $result = [
       'user_ids' => [],
       'errors'   => []
     ];

     if(!$request->has('user_ids')){
       $result['errors'] = 'user_ids is required';
     }else{
       $user_ids = json_decode($request->user_ids);
       if(!is_array($user_ids)){
         $result["errors"] = 'user_ids should be an array json format';
       }else{
         $result['user_ids'] = User::withTrashed()->whereIn('id',$user_ids)->get(['id'])->toArray();
       }
     }
     return $result;

   }
   /**
    * [usersApiValidate description]
    * @param  [type] $request [description]
    * @return [type]          [description]
    */
   public function usersApiValidate($request)
   {
     if(!$request->has('users')){
       return [
         'users' => [],
         'existing_users' => [],
         'errors' => ['users is required']
       ];
     }
     $users = json_decode($request->users);
     if(!is_array($users)){
       return $this->notAnArrayRepsonse();
     }
     return $this->userDetailValidates($users);
   }

   public function notAnArrayRepsonse()
   {
     return [
       'users' => [],
       'existing_users' => [],
       'errors' => ['users is should be in array json format']
     ];
   }

   /**
    * [userDetailValidates description]
    * @param  [type] $users [description]
    * @return [type]        [description]
    */
   public function userDetailValidates($users)
   {
     $error_line = [];
     $out_users  = collect([]);
     $existing_users = collect([]);
     $level_details = LevelDetail::with('levels')->get();
     $users_in_db   = User::withTrashed()->get();
     foreach($users as $key => $user){
       $error = [];
       if(!isset($user->forename) || !$user->forename || !ctype_alnum($user->forename)){
         $error[] = 'forename' ;
       }

       if(!isset($user->surname) || !$user->surname || !ctype_alnum($user->surname)){
         $error[] = 'surname' ;
       }

       if(!isset($user->emp_no) || !$user->emp_no || !ctype_alnum($user->emp_no)){
         $error[] = 'emp_no' ;
       }else{
         if($out_users->contains('login',$user->emp_no)){
           $error[] = 'emp_no duplicate';
         }

         if($existing_users->contains('login',$user->emp_no)){
           $error[] = 'emp_no duplicate';
         }
       }

       if(!isset($user->email) || !$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)){
         $error[] = 'email' ;
       }

       $level_id = 0;

       foreach($level_details as $level_detail){
         if(isset($user->{$level_detail->name})){
           $levels = $level_detail->levels;
           $levels = $levels->filter(function($item) use($user,$level_detail){
             return $item->name === $user->{$level_detail->name};
           });
           if(count($levels) > 0){
             $level_id = $levels[0]->id;
           }
         }
       }

       if($level_id === 0){
         $error[] = 'level';
       }

       if($error){
         $error_line[] = "line ". ($key + 1).",has error in ".implode(",",$error);
       }else{
         $out_user = [
           'firstname'  => filter_var($user->forename, FILTER_SANITIZE_STRING),
           'lastname'   => filter_var($user->surname, FILTER_SANITIZE_STRING),
           'email'      => filter_var($user->email, FILTER_SANITIZE_EMAIL),
           'login'      => filter_var($user->emp_no, FILTER_SANITIZE_STRING),
           'level_id'   => $level_id,
           'role_ids'   => [self::STUDENT_ROLE_ID],
           'password'   => 'Changeme1!',
         ];
         if ($users_in_db->contains('login',$user->emp_no)) {
           $existing_users->push($out_user);
         } else{
           $out_users->push($out_user);
         }
       }
     }

     return [
       'users' => $out_users->toArray(),
       'existing_users' => $existing_users->toArray(),
       'errors' => $error_line
     ];
   }
}
