<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Auth;
use Validator;
use Session;

use App\User as User;
use App\item_bought as Bought;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application profile.
     *
     */
    public function profile()
    {
        $loggedUser = new User();
        $yourUserID = Auth::user()->id;
        $data[0] = $loggedUser->getLoggedUser($yourUserID);

        $bought = new Bought();
        $data[1] = $bought->user_bought($yourUserID);
        return view('profile')->withdata($data);

    }

	public function editProfile(Request $request){
          // Get data from form post
        $data = array(
            "phone" => $request->input('phone'),
            "postcode" => $request->input('postcode'),
            "email" => $request->input('email')
        );

        // Build the validation rules.
        $rules = array(
            'phone'     => 'string|size:11',
            'postcode'  => array('Regex:/(^[A-Z]{1,2}[0-9R][0-9A-Z]?[\s]?[0-9][ABD-HJLNP-UW-Z]{2}$)/'),
            'email'     => 'required|email'
        );

        // Create a new validator instance.
        $validator = Validator::make($data, $rules);

        // If data is not valid
        if ($validator->fails()) {
            $messageStatus = "profile update error";
            Session::flash('messageStatus', $messageStatus);
            return redirect()->route('profile')->withErrors($validator)->withInput();
        }

        $user_id = Auth::user()->id;
        // If the data passes validation
        if ($validator->passes()) {
            $thisUser = new User();
            $userInfo = $thisUser::where('users.id', '=', $user_id)->first();

            if($data['phone'] != $userInfo->phone){
                $userInfo->phone = $data['phone'];   
            }

            if($data['email'] != $userInfo->email){
                $userInfo->email = $data['email'];   
            }

            if($data['postcode'] != $userInfo->postcode){ 
                $userInfo->postcode = $data['postcode'];          
            }
            $userInfo->save();

            $messageStatus = "success";
            Session::flash('messageStatus', $messageStatus);
            return Redirect::route('profile');
        }
    }
}
