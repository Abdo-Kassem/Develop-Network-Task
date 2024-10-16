<?php

namespace App\Services;

use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
            ->with('tags')
            ->orderBy('pinned', 'desc')
            ->latest()
            ->get();

        return $posts;
    }

    public function store(array $data)
    {
        $data['cover_image'] = 'uploads/' . $data['cover_image']->store('posts', ['disk' => 'public_directory']);
        $data['user_id'] = auth()->id();
        $tagIds = $data['tag_ids'];
        unset($data['tag_ids']);

        $post = Post::create($data);

        $post->tags()->syncWithoutDetaching($tagIds);

        return $post;
    }

    public function show($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('tags')
            ->first();
        
        if (! $post) {
            throw new Exception('Post Not Found');
        }

        return $post;
    }

    public function update(array $data, $id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $post) {
            throw new Exception('Post Not Found');
        }

        if (isset($data['cover_image'])) {
            Storage::delete($post->cover_image);
            $data['cover_image'] = 'uploads/' . $data['cover_image']->store('posts', ['disk' => 'public_directory']);
        }

        $tagIds = $data['tag_ids'];
        unset($data['tag_ids']);

        $post->update($data);

        $post->tags()->sync($tagIds);

        return $post;
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $post) {
            throw new Exception('Post Not Found');
        }

        Storage::delete($post->cover_image);
        $post->delete();

        return true;
    }

    public function SoftDeletedPosts()
    {
        $posts = Post::onlyTrashed()
            ->where('user_id', auth()->id())
            ->with('tags')
            ->get();

        return $posts;
    }

    // Restore a soft deleted post
    public function restoreSoftDeletedPost($id)
    {
        $post = Post::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $post) {
            throw new Exception('Post Not Found');
        }

        $post->restore();

        return true;
    }
}