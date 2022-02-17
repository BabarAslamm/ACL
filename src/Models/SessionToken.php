<?php

namespace Insyghts\Authentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Insyghts\Authentication\Models\User;
use Insyghts\Common\Models\BaseModel;

class SessionToken extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function checkExpiry($token)
    {
        $sessionToken = SessionToken::where('token', '=', $token)->first();

        if(!empty($sessionToken)){
            $currentDate = strtotime(gmdate('Y-m-d G:i:s'));
            $expiryDate = strtotime(gmdate('Y-m-d G:i:s', strtotime($sessionToken->expiry)));

            if($currentDate > $expiryDate){
                // token expired
                return ['status' => 0, 'message' => 'Token Expired'];
            }else{
                return ['status' => true ,  'sessionToken' => $sessionToken];
            }
        }
    }




    public function getTokenId($user_id)
    {
        $token_id = SessionToken::where('user_id', '=', $user_id)->first();
        return $token_id;
    }










}
