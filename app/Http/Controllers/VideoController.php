<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Video;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('tags')->get();

        return new JsonResponse($videos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'array|nullable',
            'tags.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $video = Video::create([
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

                    $video->tags()->save($tag);
                }
            }

            DB::commit();
            return new JsonResponse($video->load('tags'), 201);
        } catch (Exception $e) {
            DB::rollBack();

            return new JsonResponse($e->getMessage(), 500);
        }
    }
}
