<?php

namespace Modules\Authentication\app\Repository\UserInformationRepository;

use Illuminate\Support\Facades\Storage;
use Modules\Authentication\Models\UserInformation;

class UserInformationRepository {

    public function userInformationCreateOrUpdate(array $data)
    {
        $image_path = null;

        if (isset($data['image']) && $data['image'] !== null) {
            $image_path = Storage::disk('public')->put('user_information', $data['image']);
        }

         $user_information = UserInformation::updateOrCreate(
            [
           'gender' => $data['gender'],
           'date_of_birth' => $data['date_of_birth'],
           'address' => $data['address'],
           'image' => $image_path,
            'user_id' => $data['user_id'],
         ]);

         return $user_information;
    }
}