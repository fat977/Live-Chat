<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function dashboard(){
        
        return view('dashboard');
    }

    public function chat($user_id){
        $users = User::query()->where('id','!=',Auth::user()->id)->get();
        
        $sentMessages = Message::query()
        ->where('sender',Auth::user()->id)->where('receiver',$user_id)
        ->orWhere('receiver',Auth::user()->id)
        ->get();
    
        $user = User::query()->where('id',$user_id)->first();
        
        return view('chats',compact('user','users','sentMessages'));
    }

    public function send(Request $request , $receiver_id){
        Message::create([
            'sender' => Auth::user()->id,
            'receiver' => $receiver_id,
            'message' => $request->message
        ]);
        $receiver = User::query()->where('id',$receiver_id)->first();
        broadcast(new ChatSent($receiver , $request->message));
        return response()->json('success');
    }

    public function deleteMessage($message_id){
        Message::query()->where('id',$message_id)->update(['message'=>'This message is deleted']);
        return redirect()->back();
    }
}
