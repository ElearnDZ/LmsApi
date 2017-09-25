<?php namespace LmsApi\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Efront\Repositories\Efront\EfrontInterface;
use Config;
use UMS\Utils\Tree;
use App\User;

class UpdateUsers extends Command implements SelfHandling {

  private $_users_input;
  private $_efront;
  private $_tree;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($users)
	{
		$this->_users_input = $users;
    $this->_tree = new Tree;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(EfrontInterface $efront)
	{
    if(!is_array($this->_users_input)) return false;
    $users_in_db = User::withTrashed()->get();
    foreach($this->_users_input as $user_input){
      $user = $users_in_db->filter(function($item) use($user_input){
        return $item->login === $user_input['login'];
      })->first();

      if(!$user) continue;

      $user->firstname = $user_input['firstname'] ? $user_input['firstname'] : $user->firstname;
      $user->lastname  = $user_input['lastname'] ? $user_input['lastname'] : $user->lastname;
      $user->email     = $user_input['email'] ? $user_input['email'] : $user->email;
      $user->level_id  = $user_input['level_id'] ? $user_input['level_id'] : $user->level_id;
      $user->save();

      $user->roles()->sync($user_input['role_ids']);
      $level_ids = $this->_tree->getAllSubLevelIds($user->level);
      $user->accessLevels()->sync($level_ids);
      if(Config::get('efront.lms')){
         $efront->EditUser($user);
      }
    }
    return true;
	}

}
