<?php

namespace Insyghts\Authentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Insyghts\Common\Models\BaseModel;

class Permission extends BaseModel
{
    use HasFactory , SoftDeletes;

    public $table = 'permissions';



    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

}
