<?php namespace Crip\UserManager\App\Repositories;

use Crip\Core\Data\Repository;
use Crip\UserManager\App\Models\SocialLogin;

/**
 * Class SocialLoginRepository
 * @package Crip\UserManager\App\Repositories
 */
class SocialLoginRepository extends Repository
{

    /**
     * Retrieve model name
     *
     * @return string
     */
    public function model()
    {
        return SocialLogin::class;
    }

    /**
     * Allowed repo relations array
     *
     * @return array
     */
    public function relations()
    {
        return [
            'user'
        ];
    }

    /**
     * @param $social_id
     * @param $provider
     * @return SocialLogin
     */
    public function findByProvider($social_id, $provider)
    {
        return $this->where('social_id', $social_id)
            ->where('provider', $provider)
            ->firstOrFail();
    }

}