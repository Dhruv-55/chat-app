<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class GroupController extends Controller
{
    public function index(Request $request){
        return view('group.index',[
            'groups' => Group::all()
        ]);
    }


    public function insert(Request $request){
        

        $user_id = auth()->user()->id;

        if($request->image){
            if ($request->hasFile('image') && $request->file('image')->isValid()){
                $disk = Storage::disk('spaces');
                $image = Str::uuid().".".$request->file('image')->getClientOriginalExtension();
                $disk->put(env('PROFILE_IMAGE_PATH').$image,file_get_contents($request->file('image')));
            }
        }

        Group::create([
            'creator_id' => $user_id ,
            'name' => $request->name,
            'image' => $image ?? null,
            'max_user'=> $request->max_user
        ]);

        return redirect()->route('group.index');
    }

    public function delete(Request $request){
        
        Group::where('id',$request->id)->delete();
        return redirect()->route('group.index');

    }
}
