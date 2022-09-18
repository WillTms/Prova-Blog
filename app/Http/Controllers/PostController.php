<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comentario;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    // Mostrar tudo //
    public function index(){
        Post::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
        return Post::all();
    }

    // Criar um item //
    public function store(Request $request){
        $validated = Validator::make($request->all(),[
            'titulo' =>['required', 'max:30'],
            'descricao' =>['required','max:255'],
        ]);

        if(!$validated->fails()){

            $post = new Post;

            $post->titulo = $request->titulo;
            $post->descricao = $request->descricao;

            $post->id = 1;

            $post->save();

            return response()->json([
                "message" => "Post criado com sucesso"
            ], 201);
        }

        return response()->json([
            "message" => $validated->errors()->all()
        ], 500);
    }

    // Mostrar um item //
    public function show(Request $request, $id){
        if (Post::where('id', $id)->exists()){
            $post = Post::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($post, 200);
        }else{
            return response()->json([
                "message" => "Post não encontrado"
            ], 404);
        }

    }

    // Editar //
    public function edit(Request $request, $id){
        if(Post::where('id', $id)->exists()){

            $post = Post::find($id);

            $post->titulo = is_null($request->titulo) ? $post->titulo : $request->titulo;
            $post->descricao = is_null($request->descricao) ? $post->descricao : $request->descricao;

            $post->save();

            return response()->json([
                "message" => "Post Atualizado!!!"

            ], 200);
        } else {
        return response()->json([
            "message" => "Post Não Encontrado"
        ], 404);
        }

    }

    // Excluir //
    public function destroy(Request $request, $id){
        if(Post::where('id', $id)->exists()) {
            $post = Post::find($id);
            $post->delete();

            return response()->json([
                "message" => "Post Deletado"
            ], 202);
        }else{
            return response()->json([
                "message" => "Post Não Encontrado"
            ], 404);
        }

    }
}
