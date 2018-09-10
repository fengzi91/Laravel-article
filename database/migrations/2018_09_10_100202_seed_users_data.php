<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
class SeedUsersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 生成初始管理员
        $user = User::create([
            'name' => 'fengzi91',
            'email' => 'fengzi91@vip.qq.com',
            'password' => bcrypt('123456'),
        ]);
        $user->assignRole('Founder');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->truncate();
    }
}
