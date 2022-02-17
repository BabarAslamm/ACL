<?php

namespace Insyghts\Authentication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Insyghts\Common\Models\BaseModel;

class Contact extends Model
{

    use HasFactory , SoftDeletes;

    protected $fillable = [
         'created_by', 'last_modified_by', 'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function Contacts(&$response)
    {

        $Contact = Contact::paginate(30);

        $response['data'] = $Contact;
        $response['success'] = true;
    }

    public function single($id, &$response)
    {

        $Contact = Contact::where('id',$id)->first();
        if($Contact){

            $response['data'] = $Contact;
            $response['success'] = true;

        }else{
            $response['data'] = 'ID Does Not Exist';
            $response['success'] = false;

        }
    }




    public function store($data, &$response){

        $Contact = new Contact();
        $Contact->system_contact_id = $data['system_contact_id'];
        $Contact->first_name = $data['first_name'];
        $Contact->last_name  = $data['last_name'];
        $Contact->mobile     = $data['mobile'];
        $Contact->email      = $data['email'];
        $Contact->designation= $data['designation'];
        $Contact->department = $data['department'];
        $Contact->company_id = $data['company_id'];

        $current_timestamp   = gmdate('Y-m-d G:i:s');
        $Contact->created_at = $current_timestamp;
        $Contact->updated_at = $current_timestamp;

        $user_id= app('loginUser')->getUser()->id;

        $Contact->created_by = $user_id;
        $Contact->last_modified_by = $user_id;
        $Contact->deleted_by = NULL;

        $Contact->save();

        $response['data'] = $Contact;
        $response['success'] = true;


    }

    public function ConttactUpdate($data , $id , &$response){

        $Contact = Contact::where('id',$id)->first();
        if($Contact){
            $Contact->first_name  =  !empty($data['first_name'])  ? $data['first_name'] : $Contact->first_name;
            $Contact->last_name   =  !empty($data['last_name'])   ? $data['last_name']  : $Contact->last_name;
            $Contact->mobile      =  !empty($data['mobile'])      ? $data['mobile']     : $Contact->mobile;
            $Contact->email       =  !empty($data['email'])       ? $data['email']      : $Contact->email;
            $Contact->designation =  !empty($data['designation']) ? $data['designation']: $Contact->designation;
            $Contact->department  =  !empty($data['department'])  ? $data['department'] : $Contact->department;
            $Contact->company_id  =  !empty($data['company_id'])  ? $data['company_id'] : $Contact->company_id;

            $current_timestamp    = gmdate('Y-m-d G:i:s');
            $Contact->created_at  = $current_timestamp;
            $Contact->updated_at  = $current_timestamp;

            $user_id= app('loginUser')->getUser()->id;

            $Contact->last_modified_by = $user_id;
            $Contact->deleted_by = NULL;

            $Contact->update();

            $response['data'] = $Contact;
            $response['success'] = true;
        }else{
            $response['data'] = 'ID Does Not Exist';
            $response['success'] = false;
        }





    }









    public function delete_contact($id, &$response)
    {

        $Contact = Contact::where('id',$id)->first();
        if($Contact){

            $user_id= app('loginUser')->getUser()->id;
            $Contact->deleted_by = $user_id;

            $Contact->delete();
            $Contact->save();
            $response['data'] = 'Contact deleted successfull';
            $response['success'] = true;

        }else{

            $response['data'] = 'ID Does Not Exist';
            $response['success'] = false;

        }
    }


}
