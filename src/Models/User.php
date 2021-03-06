<?php

namespace Insyghts\Authentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Insyghts\Authentication\Models\SessionToken;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


use Insyghts\Common\Models\BaseModel;

class User extends Model
{

    use HasFactory, AuthenticableTrait;

    protected $fillable = [
        'contact_id', 'username', 'password', 'user_type', 'status', 'created_by', 'last_modified_by', 'deleted_by'
    ];
    public function token()
    {
        return $this->hasOne(SessionToken::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function roles1()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }




    public function can($permission = null)
    {
        echo '<pre>'; print_r($permission); exit;
        $this->checkPermission($permission);

    }


    protected function checkPermission($perm)
    {
        $permissions = $this->roles1();
        echo '<pre>'; print_r($permissions); exit;


    }


    protected function getAllPernissionsFormAllRoles()
    {
        echo '<pre>'; print_r('getAllPernissionsFormAllRoles'); exit;


    }














    public function login($data, &$response)
    {

        if ($User = User::where('username', $data['username'])->first()) {

            $credentials = array(
                "username" => $data['username'],
                "password" => $data['password'],
            );

            if (Hash::check($data['password'], $User->password)) {
                $TokenExist = User::find($User->id)->token;
                // This filter check token of user already existed , if old Token record found then delete the record and add new token record in SessionToken table
                if ($TokenExist) {
                    $TokenExist->delete();
                    $Token = md5(uniqid(rand(), true));
                    $currentDate = gmdate('Y-m-d G:i:s');

                    $expiry = gmdate('Y-m-d G:i:s', strtotime($currentDate));
                    $expiry = strtotime("+1 day", strtotime($expiry));
                    $expiry = gmdate('Y-m-d G:i:s', $expiry);
                    $d = abs(strtotime($expiry) - strtotime($currentDate));


                    $status = 'A';

                    $SessionToken = new SessionToken();
                    $SessionToken->user_id = $User->id;
                    $SessionToken->token = $Token;
                    $SessionToken->expiry = $expiry;
                    $SessionToken->status = $status;

                    $current_timestamp   = gmdate('Y-m-d G:i:s');
                    $SessionToken->created_at = $current_timestamp;
                    $SessionToken->updated_at = $current_timestamp;

                    $SessionToken->created_by = $User->id;
                    $SessionToken->last_modified_by = $User->id;
                    $SessionToken->deleted_by = NULL;

                    $SessionToken->save();
                    // Session::put('auth', auth::user());

                    $response['data'] = "Token generated successfully";
                    $response['token'] = $Token;

                    $response['expiry'] = $d;
                    $response['success'] = true;
                } else {

                    $Token = md5(uniqid(rand(), true));
                    $currentDate = gmdate('Y-m-d G:i:s');
                    $expiry = gmdate('Y-m-d G:i:s', strtotime($currentDate));
                    $expiry = strtotime("+1 day", strtotime($expiry));
                    $expiry = gmdate('Y-m-d G:i:s', $expiry);
                    $d = abs(strtotime($expiry) - strtotime($currentDate));
                    $status = 'A';

                    $SessionToken = new SessionToken();
                    $SessionToken->user_id = $User->id;
                    $SessionToken->token = $Token;
                    $SessionToken->expiry = $expiry;
                    $SessionToken->status = $status;

                    $current_timestamp   = gmdate('Y-m-d G:i:s');
                    $SessionToken->created_at = $current_timestamp;
                    $SessionToken->updated_at = $current_timestamp;


                    $SessionToken->created_by = $User->id;
                    $SessionToken->last_modified_by = $User->id;
                    $SessionToken->deleted_by = NULL;

                    $SessionToken->save();
                    // Session::put('auth', auth::user());

                    $response['data'] = "Token generated successfully";
                    $response['token'] = $Token;

                    $response['expiry'] =$d;
                    $response['success'] = true;
                }
            } else {
                $response['data'] = "Invalid Password";
            }
        } else {
            $response['data'] = "Invalid Username";
        }
    }

    public function refreshToken($token, &$response=[])
    {
        $User = $this->user($token);
        $SessionToken = SessionToken::where('token', '=', $token)->first();

        $Token = md5(uniqid(rand(), true));
        $status = 'A';
        $currentDate = gmdate('Y-m-d G:i:s');
        $expiry = gmdate('Y-m-d G:i:s', strtotime($currentDate));
        $expiry = strtotime("+1 day", strtotime($expiry));
        $expiry = gmdate('Y-m-d G:i:s', $expiry);
        $d = abs(strtotime($expiry) - strtotime($currentDate));




        $SessionToken->user_id = $User->id;
        $SessionToken->token = $Token;
        $SessionToken->expiry = $expiry;
        $SessionToken->status = $status;

        $current_timestamp   = gmdate('Y-m-d G:i:s');
        $SessionToken->created_at = $current_timestamp;
        $SessionToken->updated_at = $current_timestamp;

        $user_id= app('loginUser')->getUser()->id;

        $SessionToken->last_modified_by = $user_id;
        $SessionToken->deleted_by = NULL;

        if($SessionToken->save())
        {

            $response['data'] = "Token generated successfully";
            $response['token'] = $Token;
            $response['expiry'] = $d;
            $response['success'] = true;
        }
        return $response;
    }

    public function checkToken($token)
    {
        if (SessionToken::where('token', '=', $token)->first()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser($userId){
        $user = User::where('id' , '=' , $userId)->first();
        return $user;
    }

    public function user($token)
    {
        $userData = [];
        $user = new User();
        $sessionToken = SessionToken::where('token', '=', $token)->first();
        $user = $user->where('id', '=', $sessionToken->user_id)->first();
        $userData['id'] = $user->id;
        $userData['session_token_id'] = $sessionToken->id;
        $userData['username'] = $user->username;
        $userData['token'] = $sessionToken->token;
        $userData['expiry'] = $sessionToken->expiry;
        return (object)$userData;
    }
}
