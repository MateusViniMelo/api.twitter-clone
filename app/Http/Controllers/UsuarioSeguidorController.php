<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSeguidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UsuarioSeguidorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = DB::table("usuarios")
        ->select("usuarios.id","usuarios.name",(DB::raw("(select count(*)
            from usuario_seguidores as us 
            where
            us.id_usuario =usuarios.id  and us.id_usuario_seguindo = ".Auth::user()->id.") AS seguindo_sn " )))
        ->where("usuarios.id","<>",Auth::user()->id)
        ->orderBy("usuarios.name")
        ->get();

        
       
      return response()->json($usuarios);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UsuarioSeguidor::create([
            "id_usuario" => $request->id_usuario,
            "id_usuario_seguindo" => Auth::user()->id
        ]);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsuarioSeguidor  $usuarioSeguidor
     * @return \Illuminate\Http\Response
     */
    public function show(UsuarioSeguidor $usuarioSeguidor)
    {
        //
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UsuarioSeguidor  $usuarioSeguidor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsuarioSeguidor $usuarioSeguidor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsuarioSeguidor  $usuarioSeguidor
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsuarioSeguidor $usuarioSeguidor)
    {
        $usuarioSeguidor->delete();
        
        
    }

    public function deixarSeguir(Request $request){
        $usuarioSeguidor = UsuarioSeguidor::where("id_usuario",$request->id_usuario)
        ->where("id_usuario_seguindo",Auth::user()->id)->first();

       $this->destroy($usuarioSeguidor);
       
    }

    
}