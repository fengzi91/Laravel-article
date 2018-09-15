<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToTopicEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topic_edits', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('状态 -1 被拒绝，0 待审核，1 审核通过');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topic_edits', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
