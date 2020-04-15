<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodDrivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_drives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_name');
            $table->string('location');
            $table->integer('community_id')->unsigned();
            $table->integer('organizer_id');
            $table->tinyInteger('organizer_type');
            $table->timestamp('scheduled_at');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('community_id')->references('id')->on('communities')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blood_drives');
    }
}
