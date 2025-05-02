<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;


class LoginPage extends BaseLogin
{
    public function authenticate(): LoginResponse
    {
        $state = $this->form->getState();

        $credentials = [
            'email' => $state['email'],
            'password' => $state['password'],
        ];

        $remember = $state['remember'] ?? false;

        if (! Auth::attempt($credentials, $remember)) {
            $this->throwFailureValidationException([
                'email' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        $user = Auth::user();

        if (! $user->hasRole('admin')) {
            Auth::logout();

            $this->throwFailureValidationException([
                'email' => 'Only admins can access the admin panel.',
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
