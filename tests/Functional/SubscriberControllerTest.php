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

    /**
     * Test subscribe of a previously unsubscribed user.
     */
    public function testIsUnsubscribedAndSubscribesAgain()
    {
        $subscriber = factory(App\Subscriber::class)->create([
            'email' => 'alice@geekytheory.com',
            'token' => 'abcdef123456',
            'active' => false,
            'token_expires_at' => \Carbon\Carbon::now()->subDays(2),
            'activated_at' => \Carbon\Carbon::now()->subDays(2),
            'unsubscribed_at' => \Carbon\Carbon::now()->subDays(1),
        ]);

        $response = $this->call('POST', 'newsletter/subscribe', [
            'email' => $subscriber->email,
        ]);

        $response->assertExactJson([
            'error' => 0,
            'message' => trans('public.email_subscription_email_confirmation_sent'),
        ]);

        $this->assertDatabaseMissing('subscribers', [
            'email' => $subscriber->email,
            'token' => $subscriber->token,
            'token_expires_at' => $subscriber->token_expires_at,
        ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $subscriber->email,
            'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
        ]);
    }

    /**
     *
     */
    public function testSubscriptionConfirmation()
    {
        $subscriber = factory(App\Subscriber::class)->create([
            'email' => 'alice@geekytheory.com',
            'token' => 'abcdef123456',
            'activated' => false,
        ]);
    }

    /**
     *
     */
    public function testSubscribeError()
    {
        $subscriber = factory(App\Subscriber::class)->create([
            'email' => 'alice@geekytheory.com',
        ]);

        $response = $this->call('POST', 'subscribe-newsletter', [
            'email' => $subscriber->email,
        ]);

        $response->assertExactJson([
            'error' => 1,
            'message' => trans('public.email_subscription_wrong'),
        ]);

    }

    /**
     *
     */
    public function testRedirectToHomePageIfTokenDoesNotExist()
    {

    }

    /**
     *
     */
    public function testRedirectToHomePageIfTokenHasBeenPreviouslyActivated()
    {

    }

    /**
     *
     */
    public function testUnsubscribeUser()
    {

    }

    /**
     *
     */
    public function testRedirectToHomePageIfUserHasBeenPreviouslyUnsubscribed()
    {

    }
}
