<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTagsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tags = [
            [
                'name'        => '电竞',
                'description' => '发生在职业赛场上的梗',
            ],
            [
                'name'        => '直播',
                'description' => '弹幕文化的一部分',
            ],
            [
                'name'        => '网红',
                'description' => '明星身上的梗',
            ],
        ];

        DB::table('tags')->insert($tags);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
