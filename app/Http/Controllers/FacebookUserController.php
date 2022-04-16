<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Response;
use Facebook\Facebook;

class FacebookUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.profil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = ['name' => 'required','email' => 'required'];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ['status' => 400, "msg" => $validator->errors()->first(), 'result' =>[]];
        } else {
            try {
                $user = User::find(Auth::id());
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();
                $msg = 'Profil mis à jour';
                $arr = array("status" => 200, "msg" => $msg);
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                }
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }
        return \Response::json($arr);
    }

    

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {
    
            $user = Socialite::driver('facebook')->user();
            $isUser = User::where('facebook_app_id', $user->id)->first();
     
            if($isUser){
                Auth::login($isUser);
                return redirect('/');
            }else{
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_app_id' => $user->id,
                    'password' => encrypt('admin@123')
                ]);
    
                Auth::login($createUser);
                return redirect('/');
            }
    
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function handleFacebook() {
        return Socialite::driver('facebook')->scopes([
            "pages_show_list",
            "pages_read_engagement",
            "pages_manage_posts",
            "pages_manage_metadata",
            "publish_video",
            "pages_read_user_content",
            "public_profile",
        ])->redirect();
    }

    public function handleFacebookCallback() {
        $authenticated_user = Socialite::driver('facebook')->user();
        DB::table('users')->where('id', Auth::id())->update([
            'token' => $authenticated_user->token,
            'facebook_app_id' => $authenticated_user->id
        ]);
        return redirect()->to('/facebook/profil/informations');
    }

    public function handleFacebookPageId(Request $request) {
        $input = $request->all();
        $rules = ['facebook_page_id' => 'required'];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = ['status' => 400, "msg" => $validator->errors()->first(), 'result' =>[]];
        } else {
            try {
                $user = User::find(Auth::id());
                $user->facebook_page_id = $request->facebook_page_id;
                $user->save();
                $msg = 'ID de la page mis à jour';
                $arr = array("status" => 200, "msg" => $msg);
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                }
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }
        return \Response::json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
