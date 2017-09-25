<?php namespace LmsApi\Repositories\UserApi;

use App\User;
use UMS\Utils\Tree;
use UMS\Models\LevelDetail;
use Request;
use Queue;
use LmsApi\Traits\UserFilter;
use LmsApi\Traits\UsersValidate;
use LmsApi\Traits\UserApiLog;

use LmsApi\Requests\UserApi\DeleteRequest;
use LmsApi\Requests\UserApi\CreateRequest;
use LmsApi\Commands\CreateUsers;
use LmsApi\Commands\UpdateUsers;
use LmsApi\Commands\DeleteUsers;


class UserApiRepository implements UserApiInterface
{

  use UserFilter,UsersValidate,UserApiLog;


  private $_tree;
  const SUPERADMIN_DETAIL_ID = 1;
  const SUPERADMIN_LEVEL_ID  = 1;
  const STUDENT_ROLE_ID      = 3;

  public function __construct()
  {
    $this->_tree = new Tree;
    $responseArray = [
      'users_created' => 0,
      'users_updated' => 0,
      'users_deleted' => 0,
      'errors'        => [],
    ];
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
    return $this->userFields($this->deactivatedUsersFilter($users));
  }

  public function updateUsers(CreateRequest $request)
  {
    $input = $this->usersApiValidate($request);
    if(count($input['users']) > 0){
      Queue::push(new CreateUsers($input['users']));
    }
    if(count($input['existing_users']) > 0) {
      Queue::push(new UpdateUsers($input['existing_users']));
    }

    $this->responseArray['users_created'] = count($input['users']);
    $this->responseArray['users_updated'] = count($input['existing_users']);
    $this->responseArray['errors'] = $input['errors'];
    $this->updateLog($request,$this->responseArray);
    return $this->responseArray;
  }

  public function deleteUsers(DeleteRequest $request)
  {
    $input = $this->deleteUsersApiValidate($request);
    if(count($input['user_ids']) > 0){
      Queue::push(new DeleteUsers($input['user_ids']));
    }
    return [
      'deactivated_users' => count($input['user_ids']),
      'errors'            => $input['errors']
    ];

  }
}
