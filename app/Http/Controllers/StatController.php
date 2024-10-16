<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $stats = Cache::remember('stats', 3600,  function() {
            return [
                'total_users' => User::count(),
                'total_posts' => Post::count(),
                'users_with_no_posts' => User::doesntHave('posts')->count(),
            ];
        });

        return $this->successResponse($stats, 'Stats Retrived Successfully', 200);
    }
}
