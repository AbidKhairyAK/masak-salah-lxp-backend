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
        Schema::create('practice_single_choice_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("practice_id")->constrained("practices", "id");
            $table->text("question");
            // $table->string("image_url")->nullable(); // dicomment karena udah pake laravel media library
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
        Schema::dropIfExists('practice_single_choice_questions');
    }
};
