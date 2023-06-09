<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lname');
            $table->string('mobile')->unique();
            $table->boolean('is_admin')->default(0);
            $table->enum('gender',['Male', 'Female', 'Other']);
            $table->string('province');
            $table->string('district');
            $table->string('minicipality'); 
            $table->string('city');
            $table->string('tole');
            $table->string('word_no');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
