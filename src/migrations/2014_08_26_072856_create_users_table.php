<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('fb_id')->unique();
            $table->string('first_name')->nullable();;
            $table->string('last_name')->nullable();;
            $table->string('username', 255)->unique()->nullable();
            $table->string('password', 255)->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('postal', 5)->nullable();
            $table->string('city')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('privacy_agreement')->default(0)->nullable();
            $table->boolean('contact_post')->default(0)->nullable();
            $table->boolean('contact_email')->default(0)->nullable();

            $table->boolean('pending')->default(0);

            $table->integer('tenant_id')->unsigned()->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade');

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
        Schema::drop('users');
    }

}
