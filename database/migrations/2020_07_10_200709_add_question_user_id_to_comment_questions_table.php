<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionUserIdToCommentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('question_user_id')->nullable();

            $table->foreign('question_user_id')->references('users_id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_questions', function (Blueprint $table) {
            $table->dropForeign(['question_user_id']);
            $table->dropColumn(['question_user_id']);
        });
    }
}
