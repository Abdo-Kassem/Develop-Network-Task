<?php

namespace App\Services;

use App\Models\Tag;
use Exception;

class TagsService
{
    public function index()
    {
        return Tag::get();
    }

    public function store(array $data)
    {
        $tag = Tag::create(
            $data
        );

        return $tag;
    }

    public function show($id)
    {
        $tag = Tag::find($id);

        if (! $tag) {
            throw new Exception('This Tag Not Found');
        }

        return $tag;
    }

    public function update(array $data, $id)
    {
        $tag = Tag::find($id);
 
        if (! $tag) {
            throw new Exception('Tag Not Found');
        }

        $tag->update($data);

        return $tag;
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (! $tag) {
            throw new Exception('Tag Not Found');
        }

        return $tag->delete();

    }
}