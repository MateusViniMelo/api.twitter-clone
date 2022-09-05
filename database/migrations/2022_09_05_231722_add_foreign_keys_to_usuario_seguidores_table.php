<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsuarioSeguidoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_seguidores', function (Blueprint $table) {
            $table->foreign(['id_usuario_seguindo'])->references(['id'])->on('usuarios');
            $table->foreign(['id_usuario'])->references(['id'])->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_seguidores', function (Blueprint $table) {
            $table->dropForeign('usuario_seguidores_id_usuario_seguindo_foreign');
            $table->dropForeign('usuario_seguidores_id_usuario_foreign');
        });
    }
}
