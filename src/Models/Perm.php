<?php namespace Crip\UserManager\Models;

use Crip\Core\Data\Model;
use Crip\UserManager\App\UserManager;

/**
 * Class Perm
 * @package Crip\UserManager\Models
 */
class Perm extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(UserManager::package()->config('models.role'))
            ->withTimestamps();
    }
}