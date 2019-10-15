<?php
/**

Feedback services class to hold the related action logics

*/

namespace App\Services;

use App\Feedback;
use App\User;
use App\Mail\FeedBackNotify;
use Yajra\Datatables\Datatables;
use Mail;

class FeedbackServices{

	public function listFeedbacks(){

		$feedbacks = Feedback::with('userId')->orderBy('feedback.created_at', 'DESC')->select('feedback.*');

		return Datatables::of($feedbacks)
                ->addColumn('action', function ($feedbacks) {                  

                    $buttons = ' <button ng-click="viewFeedBack(' . $feedbacks->id . ')"  '
                            . 'title="Edit" alt="Edit" '
                            . 'class="btn pb-0 btn-circle btn-mn bg-transparent fs-20 text-blue pr-0">'
                            . '<i class="icon ion-md-eye"></i></button>';
                    return $buttons;
                })->make(true);

	}

    public function getInfo($id) {
        
        $feedback = Feedback::find($id);
        $rv = array("status" => "SUCCESS", "feedback" => $feedback);
        return response()->json($rv);
    }

    public function addOrUpdate($datas) {
        try {

            $user = \Illuminate\Support\Facades\Auth::user();

            if (isset($datas->id)) {
                $feedback = Feedback::find($datas->id);
            } else {
                $feedback = new Feedback;
            }
            
            $feedback->description = $datas->description;
            $feedback->user_id = $user->id;
            $feedback->save();

            //Send mail to admin on successful submission
            Mail::send(new FeedBackNotify(User::find($user->id), $feedback->description));

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function registerNewsletter(){
        $user = \Illuminate\Support\Facades\Auth::user();

        $letter = User::find($user->id);
        $letter->newsletter_signup = Feedback::FLAG_YES;
        $letter->save();
        return true;
    }
}