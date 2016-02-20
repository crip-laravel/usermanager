<?php namespace Crip\UserManager\App\Services;

use Auth;
use Config;
use Crip\Core\Contracts\ICripObject;
use Crip\Core\Exceptions\BadConfigurationException;
use Crip\UserManager\App\Repositories\SocialLoginRepository;
use Crip\UserManager\App\Repositories\UserRepository;
use DB;
use Laravel\Socialite\Contracts\Factory;

/**
 * Class SocialiteService
 * @package Crip\UserManager\App\Services
 */
class SocialiteService implements ICripObject
{

    /**
     * @var Socialite
     */
    private $socialite = null;

    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var SocialLoginRepository
     */
    private $social;

    /**
     * @param UserRepository $user
     * @param SocialLoginRepository $social
     */
    public function __construct(UserRepository $user, SocialLoginRepository $social)
    {
        $this->user = $user;
        $this->social = $social;
    }

    /**
     * Handle social provider callback action for authorisation
     *
     * @param string $provider
     */
    public function handle($provider)
    {
        $user = $this->socialite()->driver($provider)->user();

        //Check is this email present in DB
        $existing = $this->social->findByProvider($user->id, $provider);

        if (empty($existing)) {
            //There is no combination of this social id and provider, so create new one
            // As there no use of user if social is not created, do this in database transaction
            $existing = DB::transaction(function () use ($user, $provider) {
                $socialUser = $this->social->create([
                    'social_id' => $user->id,
                    'provider' => $provider,
                    'user_id' => $this->user->create([
                        'email' => $user->email,
                        'name' => $user->name,
                    ])->id,
                ]);

                return $socialUser;
            });
        }

        Auth::login($existing->user, true);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return mixed
     * @throws BadConfigurationException
     */
    public function redirect($provider) {
        $providerConfiguration = Config::get('services.' . $provider);
        if (empty($providerConfiguration) || !is_array($providerConfiguration)) {
            throw new BadConfigurationException($this, "Unknown provider `{$provider}`");
        }

        return $this->socialite()->driver($provider)->redirect();
    }

    /**
     * @return Factory
     */
    protected function socialite()
    {
        if ($this->socialite === null) {
            $this->socialite = app(Factory::class);
        }

        return $this->socialite;
    }
}