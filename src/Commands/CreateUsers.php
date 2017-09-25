<?php namespace LmsApi\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Efront\Repositories\EfrontApi\EfrontApiInterface;
use Efront\Repositories\EfrontApi\EfrontApiRepository;
use Efront\Repositories\Efront\EfrontInterface;

use Config;
use UMS\Utils\Tree;
use App\User;
use Log;

class CreateUsers extends Command implements SelfHandling {

  private $_users_input;
  private $_efront_api;
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
    foreach($this->_users_input as $user_input){
      $user = User::create($user_input);
      $user->roles()->sync($user_input['role_ids']);
      $level_ids = $this->_tree->getAllSubLevelIds($user->level);
      $user->accessLevels()->sync($level_ids);
      if(Config::get('efront.lms')){        
        $efront->CreateUser($user);
      }
    }
    return true;
	}

}
