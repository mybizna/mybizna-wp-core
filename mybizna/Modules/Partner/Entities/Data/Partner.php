<?php

namespace Modules\Partner\Entities\Data;

use Illuminate\Support\Facades\DB;
use Modules\Base\Classes\Datasetter;

class Partner
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $partner = DB::table('partner')->first();

        if (!$partner) {
            $user = DB::table('users')->first();

            if (!$user) {
                $user = new App\Models\User();
                $user->password = Hash::make('johndoe');
                $user->email = 'johndoe@johndoe.com';
                $user->name = 'John Doe';
                $user->is_admin = 1;
                $user->username = 'johndoe';
                $user->phone = '0723232323';
                $user->save();
            }

            $name_arr = explode(' ', $user->name);

            $first_name = $name_arr[0] ?? 'John';
            $last_name = $name_arr[1] ?? 'Doe';

            $datasetter->add_data('partner', 'partner', 'user_id', [
                "user_id" => $user->id,
                "email" => $user->email,
                "first_name" => $first_name,
                "last_name" => $last_name,
            ]);
        }
    }
}
