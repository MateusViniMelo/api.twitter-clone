<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioSeguidor extends Model
{
    use HasFactory;

    protected $table = "usuario_seguidores";
    protected $fillable = ["id_usuario","id_usuario_seguindo"];
}
