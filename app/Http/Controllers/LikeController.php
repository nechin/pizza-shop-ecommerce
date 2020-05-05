<?php

namespace App\Http\Controllers;

use App\Http\Service\LikeService;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($pizzaId)
    {
        if (!$pizzaId) {
            abort(404, 'We could not found pizza');
        }

        if (!Auth::check()) {
            abort(500, 'Authorization error');
        }

        $userId = Auth::user()->id;
        LikeService::like($pizzaId, $userId);

        return response()->json(
            ['like' => LikeService::isLiked($pizzaId, $userId)]
        );
    }
}
