<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasTable extends Migration
{
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('harga_total');
            $table->string("customer");
            $table->string('address');
            $table->string('phone');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
