<?php

namespace App\Http\Service;

use DB;

class LikeService
{
    public static function isLiked($pizzaId, $userId)
    {
        return DB::table('favorite_pizzas')
            ->where('pizza_id', $pizzaId)
            ->where('user_id', $userId)
            ->exists();
    }

    public static function like($pizzaId, $userId)
    {
        if (self::isLiked($pizzaId, $userId)) {
            self::deleteLike($pizzaId, $userId);
        } else {
            self::addLike($pizzaId, $userId);
        }
    }

    public static function addLike($pizzaId, $userId)
    {
        DB::table('favorite_pizzas')->insert(
            ['pizza_id' => $pizzaId, 'user_id' => $userId]
        );
    }

    public static function deleteLike($pizzaId, $userId)
    {
        DB::table('favorite_pizzas')->where(
            ['pizza_id' => $pizzaId, 'user_id' => $userId]
        )->delete();
    }
}
