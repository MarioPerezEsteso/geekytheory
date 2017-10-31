<?php

namespace Tests\Functional\Views;

use App\Subscriber;
use App\User;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class SubscriptionControllerViewsTest extends TestCase
{
    /**
     * @var string
     */
    protected $subscriptionCreationPageUrl = '/cuenta/suscripcion';

    /**
     * @var string
     */
    protected $paymentMethodPageUrl = '/cuenta/suscripcion/metodo-pago';

    /**
     * Test page payment method with subscription active ok.
     */
    public function testVisitPaymentMethodPageWithSubscriptionActiveOk()
    {
        // Prepare
        list($user) = TestUtils::createUserAndSusbcription();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->paymentMethodPageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('account.subscriptions.paymentMethod');
        $response->assertResponseHasData('loggedUser');
        $response->assertResponseDataModelHasValues('loggedUser', $user->attributesToArray());
    }

    /**
     * Test that visiting the payment method page without having an active subscription redirects to the subscription
     * creation page.
     */
    public function testVisitPaymentMethodPageWithoutSubscriptionRedirectsToSubscriptionCreation()
    {
        // Prepare
        $pupil = factory(User::class)->create();

        // Request
        $response = $this->actingAs($pupil)->call('GET', $this->paymentMethodPageUrl);

        // Asserts
        $response->assertRedirect($this->subscriptionCreationPageUrl);
    }

    /**
     * Test that a non-logged user can't visit the payment method page.
     */
    public function testVisitPaymentMethodPageNotAuthenticatedRedirectsToLogin()
    {
        // Request
        $response = $this->call('GET', $this->paymentMethodPageUrl);

        // Assert
        $response->assertRedirect($this->loginUrl);
    }
}
