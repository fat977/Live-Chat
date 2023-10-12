<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckCodeRequest;
use App\Mail\EmailVeification;
use App\Mail\UserEmailVerification;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)//: RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' =>['required','unique:'.User::class,'regex:/^01[0-2,5,9]{1}[0-9]{8}$/']
        ]);

        $code = rand(10000,99999);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'code'=> $code,
            'code_expired_at' => Carbon::now()->addMinutes(10)
        ]);
        $attachments = public_path('/storage/dataentry.pdf');
        
        Mail::to($user)->send(new UserEmailVerification($user,$attachments));

        //event(new Registered($user));

        Auth::login($user);
        return redirect()->route('auth.code');
        //return redirect(RouteServiceProvider::HOME);
    }

    public function code(){
        return view('auth.code');
    }
    public function checkCode(CheckCodeRequest $request){
       
        $user = User::find(Auth::user()->id);
        $now = Carbon::now();
        if($user->code == $request->code && $user->code_expired_at > $now){
            $user->email_verified_at = $now;
            $user->save();
            return redirect()->route('dashboard');
        }else{
            return redirect()->back()->with(['error'=>'code is invalid']);
        }
    }
}
