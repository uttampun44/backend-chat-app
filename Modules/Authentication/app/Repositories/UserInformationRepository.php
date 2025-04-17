<?php

namespace Modules\Authentication\app\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Authentication\Models\UserInformation;
use Illuminate\Support\Str;

class UserInformationRepository {
   
    public function userLists()
    {  
         try {
            $users = User::with('userInformations')->where('id', '!=', Auth::user()->id)->get();
            return response()->json($users, 200);
         } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
         }
    }
    public function userInformationCreateOrUpdate(array $data)
    {
        $image_path = null;
 
        if (isset($data['image']) && $data['image'] !== null) {
            $image_path = Storage::disk('public')->put('UserInformation',  $data['image']);
        }

         $user_information = UserInformation::updateOrCreate(
            [
           'gender' => $data['gender'],
           'date_of_birth' => $data['date_of_birth'],
           'address' => $data['address'],
           'image' => $image_path,
           'user_id' => Auth::user()->id,
         ]);

         return $user_information;
    }
}