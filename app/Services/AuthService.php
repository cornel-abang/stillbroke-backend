<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\ResetPasswordEmail;
use App\Models\VerificationCode;
use App\Events\ClientCreatedEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function registerUser(array $details): string|bool
    {
        $user = User::create($details);
        
        if (!$user || !$token = auth()->login($user)) {
            return false;
        }

        event(new ClientCreatedEvent($user));

        return $token;
    }

    public function loginUser(array $details): array|bool
    {
        $user = User::where('email', $details['email'])->first();
        
        if (!$user) {
            return false;
        }

        if (!Hash::check($details['password'], $user->getAuthPassword())) {
            return false;
        }
        
        if (!$token = auth()->login($user)) {
            return false;
        }

        return ['token' => $token, 'user' => $user];
    }

    public function checkVerification(array $request): bool
    {
        $code = VerificationCode::where('code', $request['code'])
            ->where('user_id', $request['user_id'])
            ->where('email', $request['email'])
            ->first();
        
        if (! $code) {
            return false;
        }

        $user = User::find($request['user_id']);

        if (! $user) {
            return false;
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return true;
    }

    public function updateClientInfo(int $user_id, array $requestInfo): bool
    {
        $user = User::find($user_id);

        if (! $user) {
            return false;
        }

        $user->update($requestInfo);

        return true;
    }

    public function sendPasswordResteEmail(string $email): bool
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return false;
        }

        $client_name = $user->first_name.' '.$user->last_name;

        Mail::to($user->email)->send(new ResetPasswordEmail($client_name));

        return true;
    }

    public function updateUserPassword(array $details): void
    {
        $user = User::where('email', $details['email'])->first();
        $user->update(['password' => $details['password']]);
    }

    public function logoutUser(): void
    {
        // Pass true to invalidate the token forever
        auth()->logout(true);
    }
}
