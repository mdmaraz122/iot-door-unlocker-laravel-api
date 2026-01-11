<?php

namespace App\Helpers;

class GetUserID
{
    public static function user_id($token)
    {
        // Decode the JWT token
        $payload = JWTToken::ReadToken($token);
        if ($payload && isset($payload->userID)) {
            return $payload->userID;
        }
        return null;
    }
}
