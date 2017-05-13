<?php

class SubscriberControllerTest extends TestCase
{
    /**
     * Test subscribe without confirmation ok.
     */
    public function testSubscribeWithoutConfirmOk()
    {
        $email = 'random@email.com';
        $response = $this->call('POST', 'newsletter/subscribe', [
            'email' => $email,
        ]);

        $response->assertExactJson([
            'error' => 0,
            'message' => trans('public.email_subscription_email_confirmation_sent'),
        ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $email,
            'active' => false,
            'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
            'activated_at' => null,
            'unsubscribed_at' => null,
        ]);
    }
}
