<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        $users = factory(User::class)->times(80)->make();

        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $user = User::find(1);
        $user->name = 'fengzi91';
        $user->email = 'fengzi91@vip.qq.com';
        $user->password = bcrypt('123000qq');
        $user->assignRole('Founder');
        $user->save();
        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->name = 'fengzi92';
        $user->email = '393011655@qq.com';
        $user->password = bcrypt('123000qq');
        $user->assignRole('Maintainer');
        $user->save();
    }
}
