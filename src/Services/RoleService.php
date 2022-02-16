<?php
namespace Insyghts\Authentication\Services;

use Insyghts\Authentication\LoginUser;
use Insyghts\Authentication\Models\Role;

class RoleService{

    function __construct(Role $role, LoginUser $loginUser) {

        $this->role = $role;
        $this->loginUser = $loginUser;

    }

    public function roles()
    {
      $response = [
          'success' => false,
          'data' => 'Erorr',
      ];
      $Role = new Role();
      $this->role->roles($response);
      return $response;

    }

}
