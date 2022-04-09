<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('tags')->get();

        return new JsonResponse($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'array|nullable',
            'tags.*' => 'string',
        ]);

        try {
            DB::beginTransaction();

            $post = Post::create([
                'title' => $request->title
            ]);

            if($request->tags) {

                foreach($request->tags as $tag) {

                    $slug = Str::slug($tag, '-');

                    $tag = Tag::firstOrCreate([
                        'slug' => $slug
                    ], [
                        'tag' => $tag
                    ]);

                    $post->tags()->save($tag);
                }
            }

            DB::commit();
            return new JsonResponse($post->load('tags'), 201);
        } catch (Exception $e) {
            DB::rollBack();

            return new JsonResponse($e->getMessage(), 500);
        }
    }
}
