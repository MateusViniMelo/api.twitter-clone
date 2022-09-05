<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\UsuarioSeguidor;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quantidade_tweets = Tweet::where("id_usuario",Auth::user()->id)->count();
        $quantidadeSeguidores= UsuarioSeguidor::where("id_usuario",Auth::user()->id)->count();
        $quantidadeUsuariosSeguindo= UsuarioSeguidor::where("id_usuario_seguindo",Auth::user()->id)->count();

        $tweets = Tweet::orderByDesc("created_at")->get();

        return response()->json(
            [
                "quantidadeTweets" => $quantidade_tweets, 
                "quantidadeSeguidores" => $quantidadeSeguidores, 
                "quantidadeUsuariosSeguindo" => $quantidadeUsuariosSeguindo, 
                "tweets" => $tweets->load("usuarios")
            ]
        );
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regras = [
            "tweet" => "required|max:280"
        ];

        $feedback = [
            "required" => "Preencha um texto pata tweetar.",
            "max" => "O texto deve conter no máximo 280 letras."
        ];

        $request->validate($regras,$feedback);
        $tweet = new Tweet();

        $tweet->id_usuario = Auth::user()->id;
        $tweet->tweet = $request->tweet;
        $tweet->save();
        return response()->json($tweet);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        
    }
}
