<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    function getAllArticles()
    {
        return Article::all();
    }

    // function getArticle($id)
    // {
    //     return Article::findOrFail($id);
    // }

    //implicit binding
    function getArticle(Article $article)
    {
        return $article;
    }

    function createArticle(Request $request)
    {
        // $title      = $request->title;
        // $content    = $request->content;
        // $user       = $request->user();

        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->user_id = $request->user()->id;
        $article->save();
        return $article;
    }

    function updateArticle(Request $request, Article $article)
    {
        $user = $request->user();
        if ($user->id != $article->user_id) {
            return response()->json(["error" => "Sorry!!! Your not authorized"], 404);
        } else {
            $article->title = $request->title;
            $article->content = $request->content;
            $article->save();
            return $article;
        }
    }

    function deleteArticle(Request $request, Article $article)
    {
        $user = $request->user();
        if ($user->id != $article->user_id) {
            return response()->json(["error" => "Sorry!!! Your not authorized"], 404);
        } else {
            $article->delete();
            return response()->json(["success" => "Sucessfully deleted!!!"], 200);;
        }
    }
}
