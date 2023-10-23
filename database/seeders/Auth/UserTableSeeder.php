<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Database\Seeders\BaseSeeder;

class UserTableSeeder extends BaseSeeder
{
    /**
     * Data for the seeder.
     */
    const DATA = [
        [
            'name' => 'user',
            'email' => 'testuser@email.n',
            'password' => 'a',
        ],
    ];

    /**
     * Runs the seeder.
     *
     * @return void
     */
    public function run()
    {
        collect(self::DATA)->each(function (array $data) {
            if($this->exists(new User(), 'email', $data['email'])) {
                return 0;
            }

            $u  = new User();
            $u->name = $data['name'];
            $u->email = $data['email'];
            $u->password = bcrypt($data['password']);
            $u->save();
        });
    }
}
