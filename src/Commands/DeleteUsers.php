<?php namespace LmsApi\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Efront\Repositories\Efront\EfrontInterface;
use Config;
use App\User;
use Log;

class DeleteUsers extends Command implements SelfHandling {

  private $_user_ids;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($user_ids)
	{
		$this->_user_ids = $user_ids;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(EfrontInterface $efront)
	{
    if(!is_array($this->_user_ids))return false;

    foreach($this->_user_ids as $user_id){      
      $user = User::find($user_id['id']);
      if($user){
        (Config::get('efront.lms')) ? $efront->DeactivateUser($user) : $user->delete();
      }
    }
    return true;
	}

}
