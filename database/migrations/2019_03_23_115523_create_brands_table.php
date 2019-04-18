<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}