<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);

        return $this->sendResponse($users, 'users found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        $user = User::findOrFail($id);

        return $this->sendResponse($user, 'user found');
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
        $user = User::findOrFail($id);

        $data = $request->only('email','name');

        if ($editUser = $user->updateUser($data)) {
            return $this->sendResponse($editUser,'user updated successfully');
        }

        return $this->sendError('user not updated', [], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

       return $this->sendResponse($id, 'user deleted successfully');
    }

    /**
     *  Returns profile picture
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getProfilePicture($id) 
    {
        $user = User::findOrFail($id);

        return response()->file(storage_path($user->photo));
    }


    /**
     *  upload profile picture
     * 
     * @param  int $id
     * @return \Illuminate\Http\Request $request 
     */
    public function uploadProfilePicture(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {
            
            $validator = Validator::make($request->all(),[
                'photo' => 'image|mimes:jpg,png,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                return $this->sendError('error upload photo', $validator->errors(),400);
            }

            $path = $request->file('photo')->store('public/photo');

            if ($user->photo){
                Storage::delete($user->photo);
            }

            $user->photo = $path;

            $user->save();

            return $this->sendResponse($user->fresh() ,'user updated successfully');
        }

    }
}
