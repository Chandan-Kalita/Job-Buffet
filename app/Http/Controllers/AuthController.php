<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function index(Request $r, $page = '')
    {
        if ($r->session()->exists('USERID')) {

            if($page == '' || $page == 'dashboard'){

                return view('dashboard.'.session('ROLE'));
            }
        }
        if ($page == '' || $page == 'client-login') {

            return view('login.client-login');
        } elseif ($page == 'agency-login') {

            return view('login.agency-login');
        } elseif ($page == 'agency-register') {

            return view('login.agency-register');
        } elseif ($page == 'client-register') {

            return view('login.client-register');
        } else {

            abort(404);
        }
    }

    private function makeLogin($email,$user_id,$role){
        $entity_id = DB::table($role.'_master')->where('email',$email)->value($role.'_id');

        session()->put('ENTITYID',$entity_id);
        session()->put('USERID',$user_id);
        session()->put('EMAIL',$email);
        session()->put('ROLE',$role);
    }

    function login_submit(Request $r, $role){
        extract($r->all());
        $validator = Validator::make($r->all(), [
            'email' => ['required'],
            'password' => 'required',
            'latitude'=> ($role=='client')?'required':'nullable',
            'longitude'=> ($role=='client')?'required':'nullable',
        ]);
        if ($validator->passes()) {
            $user = DB::table('users')->select(['user_id','email','password','role'])->where('email',$email)->where('role',$role)->first();
            if($user){
                if(Hash::check($password, $user->password)){
                    $this->makeLogin($user->email,$user->user_id,$role);
                    return redirect('/dashboard');
                }
            }
            $url = url('').'/'.$role."-login";
            return redirect($url);

        }else{
            $errors = $validator->errors()->getMessages();
            $html = genErrorList($errors);
            $r->session()->flash('status', $html);
            $url = url('').'/'.$role."-login";
            return redirect($url);
        }
    }

    function register_submit(Request $r, $role)
    {
        extract($r->all());
        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => ['required', Rule::unique('users','email')],
            'password' => 'required',
            'address' => 'required',
            'latitude'=> ($role=='client')?'required':'nullable',
            'longitude'=> ($role=='client')?'required':'nullable',
        ]);
        if ($validator->passes()) {
            $user_id = DB::table('users')->insertGetId([
                'email'=>$email,
                'password'=>Hash::make($password),
                'role'=>$role
            ]);
            if ($role == 'client') {
                DB::table('client_master')->insert([
                    'name'=>$name,
                    'phone'=>$phone,
                    'email'=>$email,
                    'address'=>$address,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude
                ]);

            } elseif ($role == 'agency') {
                DB::table('agency_master')->insert([
                    'name'=>$name,
                    'phone'=>$phone,
                    'email'=>$email,
                    'address'=>$address
                ]);
            }
            
            $this->makeLogin($email,$user_id,$role);
            return redirect('/dashboard');
        }else{
            $errors = $validator->errors()->getMessages();
            $html = genErrorList($errors);
            $r->session()->flash('status', $html);
            $url = url('').'/'.$role."-register";
            return redirect($url);
        }
    }
}
