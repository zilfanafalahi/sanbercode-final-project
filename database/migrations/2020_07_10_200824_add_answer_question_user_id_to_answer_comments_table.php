<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerQuestionUserIdToAnswerCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answer_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('answer_question_user_id')->nullable();

            $table->foreign('answer_question_user_id')->references('answer_user_id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answer_comments', function (Blueprint $table) {
            $table->dropForeign(['answer_question_user_id']);
            $table->dropColumn(['answer_question_user_id']);
        });
    }
}
