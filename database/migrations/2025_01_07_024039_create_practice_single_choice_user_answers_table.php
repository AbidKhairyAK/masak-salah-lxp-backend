<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('practice_single_choice_user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users", "id");
            $table->foreignId("question_id")->constrained("practice_single_choice_questions", "id");
            $table->foreignId("selected_option_id")->constrained("practice_single_choice_options", "id");
            $table->boolean("is_correct");
            $table->string("created_by");
            $table->string("updated_by");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_single_choice_user_answers');
    }
};
