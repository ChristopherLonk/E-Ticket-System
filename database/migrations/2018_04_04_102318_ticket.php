<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enum\Priority;
use App\Enum\Status;
use App\Enum\StoryPoints;

class Ticket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('created_from');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('sprint_id')->nullable();
            $table->string('name');
            $table->integer('is_delete')->default(null)->nullable();
            $table->longText('description');
            $table->enum('status', Status::getEnum());
            $table->enum('storyPoints', StoryPoints::getEnum());
            $table->enum('priority', Priority::getEnum());
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_from')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('sprint_id')->references('id')->on('sprint');
            $table->string('ext_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
