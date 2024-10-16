<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class CacheObserver
{
    public function created(): void
    {
        Cache::forget('stats');
    }


    public function updated(): void
    {
        Cache::forget('stats');
    }

    
    public function deleted(): void
    {
        Cache::forget('stats');
    }

   
    public function restored(): void
    {
        Cache::forget('stats');
    }

    
    public function forceDeleted(): void
    {
        Cache::forget('stats');
    }
}
