<?php

namespace App\Services;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\User;
use App\Models\Product;
use App\Events\PaymentMadeEvent;

class PaymentService
{
    public function makePayment(array $info): array
    {
        Stripe::setApiKey(config('app.stripe_secret'));
        
        try {
            $charge = Charge::create([
                'amount' => $info['amount'],
                'currency' => 'usd',
                'source' => $info['stripeToken'],
                'description' => 'Stillbroke - Payment',
            ]);
            
            if ($charge->paid && $charge->status === 'succeeded') {
                
                $info = [
                    'amount' => $info['amount'], 
                    'user_id' => $info['user_id'],
                    'cart_token' => $info['cart_token'],
                    'payment_ref' => $charge->id,
                    'receipt_url' => $charge->receipt_url,
                ];

                event(new PaymentMadeEvent($info));
            }

            return [true, 'Payment successful'];
        } catch (\Exception $e) {
            return [false, $e->getMessage()];
        }
    }
}
