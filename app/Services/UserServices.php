<?php
/**

User services class to hold the related action logics

*/

namespace App\Services;

use App\User;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class UserServices{

	public function listUsers($status){

		$user = User::select(['id','name','firm_name','position','contact_number','email',
                            'is_active','is_admin']);

        if(!empty($status)){
            $user->where('is_active', $status);
        }

		return Datatables::of($user)
                ->addColumn('status_text',function($user){
                    if($user->is_active == User::FLAG_YES){
                        return User::STATUS_ACTIVE_TEXT;
                    }else{
                        return User::STATUS_IN_ACTIVE_TEXT;
                    }
                })
                ->addColumn('action', function ($user) {                  

                    $buttons = ' <button ng-click="editUser(' . $user->id . ')"  '
                            . 'title="Edit" alt="Edit" '
                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
                            . '<ion-icon name="create"></ion-icon></button>';

                    return $buttons;
                })->make(true);
	}


	public function getInfo($id) {
        
        $user = User::find($id);

        $rv = array("status" => "SUCCESS", "user" => $user);

        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $user = User::find($datas->id);
            } else {
                $user = new User;
            }
            
            $user->name = $datas->name;
            $user->firm_name = $datas->firm_name;
            $user->position = $datas->position;
            $user->contact_number = $datas->contact_number;
            $user->email = $datas->email;

            if($datas->is_active == User::FLAG_YES){
                $user->is_active = User::FLAG_YES;
                $user->approved_at = Carbon::now();
            }else{
                $user->is_active = User::FLAG_NO;
                $user->approved_at = NULL;
            }

            $user->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
            User::destroy($id); 
            return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function emailExists($data){
        if(isset($data)){
            $mapping = User::where('email', $data->email)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = User::where('email', $data->email)
                            ->count();
        }

        if($mapping){
            return true;
        }
        return false;
    }
}