<?php

namespace Insyghts\Authentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Insyghts\Common\Models\BaseModel;


class Role extends Model
{
    use HasFactory , SoftDeletes;

    public $table = 'roles';


    // public function permissions(){
    //     return $this->belongsToMany(Permission::class,'permission_id');
    // }
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_permissions');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function roles(&$response)
    {
        $Role = Role::paginate(30);

        $response['data']    = $Role;
        $response['success'] = true;
    }

}

