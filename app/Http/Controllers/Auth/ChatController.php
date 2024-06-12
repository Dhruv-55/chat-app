<?php

namespace App\Http\Controllers\Auth;

use App\Events\ChatEvent;
use App\Events\DeleteChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;


class ChatController extends Controller
{
    public function insert(Request $request){
        try{

            $chat = Chat::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message
            ]);
            
            Event(new ChatEvent($chat));

            return response()->json(['success' => true , 'data' => $chat]);

        }catch(\Exception $e){
            return response()->json(['success' => false , 'message' => $e->getMessage()]);

        }
    }

    public function index(Request $request){
        try{

            $chats = Chat::where(function($q) use($request) {
                    $q->where('sender_id',$request->sender_id)
                    ->orWhere('sender_id',$request->receiver_id);
                 })->where(function($q) use($request) {
                    $q->where('receiver_id',$request->sender_id)
                    ->orWhere('receiver_id',$request->receiver_id);
                 })->get();

                 return response()->json(['success' => true,'chats' => $chats]);

        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function delete(Request $request){
        try{

            if(! $chat = Chat::where('id',$request->id)->first())
                return response()->json(['success' => false,'message' => 'Something Went Wrong']);

                $chat->delete();
                event(new DeleteChatEvent($request->id));

                return response()->json(['success' => true,'data' => $chat]);

        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }
}
