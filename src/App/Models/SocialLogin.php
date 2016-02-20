<?php namespace Crip\UserManager\App\Models;

use Crip\Core\Data\Model;
use Crip\UserManager\App\UserManager;

/**
 * Class SocialLogin
 * @package Crip\UserManager\App\Models
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
        return $this->belongsTo(UserManager::package()->config('name'));
    }

}