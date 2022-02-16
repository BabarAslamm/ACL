<?php

namespace Insyghts\Authentication\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Insyghts\Authentication\Middleware\myAuth;
use Insyghts\Authentication\Models\Role;
use Insyghts\Authentication\Models\Permission;
use Insyghts\Authentication\Services\RoleService;
use Insyghts\Common\Controllers\CommonController;

class RoleController extends CommonController
{

    public function __construct(RoleService $RoleService)
    {
        $this->middleware(myAuth::class);
        $this->roleService = $RoleService;
    }

    public function roles(Request $request)
    {

        // $Contact = new Role();
        // $result = $this->roleService->roles();
        $Permission = Permission::find(1)->roles;

        return response()->json($Permission);

    }

}
