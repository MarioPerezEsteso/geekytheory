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
    protected $createSubscriptionURL = '/suscripcion';

    /**
     * @var string
     */
    protected $showSubscriptionURL = '/cuenta/suscripcion';

    /**
     * @var string
     */
    protected $paymentMethodPageUrl = '/cuenta/suscripcion/metodo-pago';

    /**
     * Test that user that hasn't an active subscription can visit the subscription create page ok.
     */
    public function testVisitSubscriptionCreatePageOk()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->createSubscriptionURL);

        // Asserts
        $response->assertStatus(200);
        $response->assertViewIs('courses.subscription');
    }

    /**
     * Test visit subscription create page redirects to subscription show page if user has subscription active
     */
    public function testVisitSubscriptionCreatePageRedirectsToSubscriptionShowPageIfUserHasSubscriptionActive()
    {
        // Prepare
        list($user) = TestUtils::createUserAndSubscription();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->createSubscriptionURL);

        // Asserts
        $response->assertRedirect($this->showSubscriptionURL);
    }

    /**
     * Test that if non-logged user visits the subscription create page, the user is redirected to registration page.
     */
    public function testVisitSubscriptionCreatePageOfNonLoggedUserRedirectsToRegistrationPage()
    {
        // Request
        $response = $this->call('GET', $this->createSubscriptionURL);

        // Assert
        $response->assertRedirect($this->registrationUrl);
        $response->assertSessionHas('message', 'Crea una cuenta antes de obtener tu suscripción Premium');
    }

    /**
     * Test that a user with an active subscription can visit subscription show page.
     */
    public function testVisitSubscriptionShowPageOk()
    {
        // Prepare
        list($user, $subscription) = TestUtils::createUserAndSubscription();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->showSubscriptionURL);

        // Asserts
        $response->assertStatus(200);
        $response->assertViewIs('account.subscriptions.subscription');
        $response->assertResponseHasData('subscription');
        $response->assertResponseDataModelHasValues('subscription', $subscription->attributesToArray());
    }

    /**
     * Test that a user without an active subscription can't visit the subscription show page and is redirected to
     * subscription creation page.
     */
    public function testVisitSubscriptionShowPageRedirectsToSubscriptionCreationPageIfUserHasNotSubscriptionActive()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->showSubscriptionURL);

        // Asserts
        $response->assertRedirect($this->createSubscriptionURL);
    }

    /**
     * Test that if non-logged user visits the subscription show page, the user is redirected to login page.
     */
    public function testVisitSubscriptionShowPageOfNonLoggedUserRedirectsToLoginPage()
    {
        // Request
        $response = $this->call('GET', $this->showSubscriptionURL);

        // Assert
        $response->assertRedirect($this->loginUrl);
    }

    /**
     * Test page payment method with subscription active ok.
     */
    public function testVisitPaymentMethodPageWithSubscriptionActiveOk()
    {
        // Prepare
        list($user) = TestUtils::createUserAndSubscription();

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
    public function testVisitPaymentMethodPageWithoutSubscriptionRedirectsToSubscriptionCreationPage()
    {
        // Prepare
        $pupil = factory(User::class)->create();

        // Request
        $response = $this->actingAs($pupil)->call('GET', $this->paymentMethodPageUrl);

        // Asserts
        $response->assertRedirect($this->createSubscriptionURL);
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
