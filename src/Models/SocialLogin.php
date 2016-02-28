<?php namespace Crip\UserManager\Models;

use Crip\Core\Data\Model;

/**
 * Class SocialLogin
 * @package Crip\UserManager\Models
 */
class SocialLogin extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'social_logins';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider', 'social_id'];

    /**
     * @return BelongsTo
     */
    public function User()
    {
        return $this->belongsTo(config('auth.model'));
    }

}