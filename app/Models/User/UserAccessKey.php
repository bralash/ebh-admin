<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Utility\Generator;

class UserAccessKey extends Model
{
	protected $table = 'user_access_keys';
	protected $fillable = ['user_id', 'api_key'];

    /**
     * Generates a 60 char access token
     *
     * @return string
     **/
    public static function new()
    {
        return Generator::generateCode(60, 'ALPHA_NUM');
    }

    /**
     * Check users for user with matching token
     *
     * @param string $accessToken  The access tokenC:\xampp\htdocs\iincomer\app\Models\User\Access.php
     *
     * @return mixed
     **/
    public static function attempt($accessToken) {
        if (strlen($accessToken) != 60) return null;

        // Get access key match
        $access = self::where('api_key', $accessToken)->first();

        try {
            switch ($access->status) {
                // Check for access key status
                case 1:
                    return $access;
                    break;

                default:
                    return null;
                    break;
            }
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }
}
