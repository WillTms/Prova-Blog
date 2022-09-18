<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    // Mostrar tudo //
    public function index(Request $request){
        Comment::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
        return Comment::where('post_id', $id)->get();
    }

    // Criar um item //
    public function store(Request $request, $id){

        $valited = Validator::make($request->all(),[
            'usuario' => ['required', 'max:30'],
            'descricao' => ['required', 'max:50'],
        ]);

        if(!$validated->fails()){

            $comment = new Comment;

            $comment->usuario = $request->usario;
            $commet->descricao = $request->descricao;
            $comment->post_id = $id;

            $comment->save();

            return response()->json([
                "message" => "Comentario criado com sucesso"
            ], 201);
        }

        return response()->json([
            "message" => $validated->errors()->all()
        ], 500);

    }
    // Mostrar um item //
    public function show(Request $request){
        if (Comment::where('id', $id_descricao)->exists()) {
            $comment = Comment::find($id_descricao);

            if(!($comment->post_id == $id)){
                return response()->json([
                    "message" => "Comentário não encontrado na postagem"
                ], 404);
            }

            return response($Comment, 200);
        } else {
            return response()->json([
                "message" => "Comentário não encontrado"
            ], 404);
        }


    }
    // Editar //
    public function edit(Request $request, $id, $id_descricao){
        if (Comment::where('id', $descricao)->exists()) {

            $comment = Comment::find($id_descricao);

            if(!($comment->post_id == $id)){
                return response()->json([
                    "message" => "Comentario não encontrado na postagem"
                ], 404);
            }

            $comment->descricao = ($request->has('descricao')) ? $request->descricao : $comment->descricao;
            $comment->save();

            return response()->json([
                "message" => "Comentario atualizado com sucesso"
            ], 200);
        } else {
            return response()->json([
                "message" => "Comentario nao encontrado"
            ], 404);
        }

    }
    // Excluir //
    public function destroy(Request $request, $id, $id_descricao){
        if(Comment::where('id', $id_descricao)->exists()) {

            $descricao = Comment::find($id_descricao);

            if(!($descricao->post_id == $id)){
                return response()->json([
                    "message" => "Comentário nao encontrado na postagem"
                ], 404);
            }

            $descricao->delete();

            return response()->json([
                "message" => "Comentário deletado"
            ], 202);
        }else{
            return response()->json([
                "message" => "Comentário não encontrado"
            ], 404);
        }

    }
}
