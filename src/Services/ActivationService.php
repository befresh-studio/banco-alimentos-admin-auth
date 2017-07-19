<?php

namespace Brackets\AdminAuth\Services;

use Brackets\AdminAuth\Contracts\Auth\CanActivate as CanActivateContract;
use Brackets\AdminAuth\Facades\Activation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ActivationService
{

    /**
     * Handles activation creation after user created
     *
     * @param CanActivateContract $user
     * @return boolean
     */
    public function handle(CanActivateContract $user)
    {
        if(!Config::get('admin-auth.activation-required') && Schema::hasTable('activations') && Schema::hasColumn('users', 'activated')) {
            return false;
        }

        // We will send the activation link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendActivationLink(
            $this->credentials($user)
        );

        if($response == Activation::ACTIVATION_LINK_SENT) {
            Log::info('Activation e-mail has been send: '. trans($response));
        } else {
            Log::erro('Sending activation e-mail has failed: '. trans($response));
        }

        return true;
    }

    /**
     * Get the needed authorization credentials from user.
     *
     * @param CanActivateContract $user
     * @return array
     */
    protected function credentials(CanActivateContract $user)
    {
        return ['email' => $user->getEmailForActivation()];
    }

    /**
     * Get the broker to be used during activation.
     *
     * @return \Brackets\AdminAuth\Contracts\Auth\ActivationBroker
     */
    public function broker()
    {
        return Activation::broker();
    }
}