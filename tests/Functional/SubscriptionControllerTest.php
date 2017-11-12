<?php

namespace Tests\Functional;

use App\User;
use Tests\Helpers\TestConstants;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    /**
     * Subscription creation POST URL.
     *
     * @var string
     */
    protected $subscriptionCreatePostUrl = '/account/subscription';

    /**
     * Subscription page URL.
     *
     * @var string
     */
    protected $subscriptionPageUrl = '/cuenta/suscripcion';

    /**
     * Update subscription card POST URL.
     *
     * @var string
     */
    protected $subscriptionCardUpdatePostUrl = '/account/subscription/card';

    /**
     * Subscription payment method page URL.
     *
     * @var string
     */
    protected $subscriptionPaymentMethodPageUrl = '/cuenta/suscripcion/metodo-pago';

    /**
     * Test create subscription successfully.
     *
     * @dataProvider providerTestCreateSubscriptionOk
     * @param array $example
     */
    public function testCreateSubscriptionOk($example)
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $requestData = [
            'stripe_token' => $example['stripeToken'],
        ];

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCreatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPageUrl);
        $response->assertSessionHas('success', trans('home.subscription_created'));

        // Database asserts
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'card_brand' => $example['cardBrand'],
            'card_last_four' => $example['cardLastFour'],
            'trial_ends_at' => null,
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'name' => TestConstants::MODEL_SUBSCRIPTION_PLAN_NAME,
            'stripe_plan' => TestConstants::MODEL_SUBSCRIPTION_PLAN_MONTHLY,
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);
    }

    /**
     * Data provider for testCreateSubscriptionOk.
     *
     * @return array
     */
    public function providerTestCreateSubscriptionOk(): array
    {
        return [
            [
                [
                    'stripeToken' => 'tok_visa',
                    'cardLastFour' => '4242',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_visa_debit',
                    'cardLastFour' => '5556',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard',
                    'cardLastFour' => '4444',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard_debit',
                    'cardLastFour' => '8210',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard_prepaid',
                    'cardLastFour' => '5100',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_amex',
                    'cardLastFour' => '8431',
                    'cardBrand' => 'American Express',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mx',
                    'cardLastFour' => '0008',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_es',
                    'cardLastFour' => '0007',
                    'cardBrand' => 'Visa',
                ]
            ],
        ];
    }

    /**
     * Test the different Stripe errors that could be received on a subscription creation.
     *
     * @dataProvider providerTestSubscriptionNotCreatedAndCreditCardNotStoredWithErrorsFromStripe
     * @param array $example
     */
    public function testSubscriptionNotCreatedAndCreditCardNotStoredWithErrorsFromStripe($example)
    {
        $requestData = [
            'stripe_token' => $example['stripe_token'],
        ];

        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCreatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPageUrl);

        $response->assertSessionHasErrors(['stripe_error' => trans($example['expected_error'])]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'card_brand' => null,
            'card_last_four' => null,
            'trial_ends_at' => null,
        ]);

        $this->assertDatabaseMissing('subscriptions', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Data provider for testSubscriptionNotCreatedAndCreditCardNotStoredWithErrorsFromStripe.
     *
     * @return array
     */
    public function providerTestSubscriptionNotCreatedAndCreditCardNotStoredWithErrorsFromStripe(): array
    {
        return [
            [
                [
                    'stripe_token' => 'tok_cvcCheckFail',
                    'expected_error' => 'home.credit_card_cvv_incorrect',
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclined',
                    'expected_error' => 'home.credit_card_not_valid'
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedIncorrectCvc',
                    'expected_error' => 'home.credit_card_cvv_incorrect'
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedExpiredCard',
                    'expected_error' => 'home.credit_card_expired'
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedProcessingError',
                    'expected_error' => 'home.stripe_processing_error'
                ],
            ], [
                [
                    'stripe_token' => 'tok_avsZipFail',
                    'expected_error' => 'home.incorrect_zip'
                ],
            ], [
                [
                    'stripe_token' => 'tok_avsFail',
                    'expected_error' => 'home.incorrect_zip'
                ],
            ],
        ];
    }

    /**
     * Test the different Stripe errors that could be received on a subscription creation.
     *
     * @dataProvider providerTestSubscriptionNotCreatedButCreditCardStoredWithErrorsFromStripe
     * @param array $example
     */
    public function testSubscriptionNotCreatedButCreditCardStoredWithErrorsFromStripe($example)
    {
        $requestData = [
            'stripe_token' => $example['stripe_token'],
        ];

        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCreatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPageUrl);

        $response->assertSessionHasErrors(['stripe_error' => trans($example['expected_error'])]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'card_brand' => $example['card']['brand'],
            'card_last_four' => $example['card']['last_four'],
            'trial_ends_at' => null,
        ]);

        $this->assertDatabaseMissing('subscriptions', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Data provider for testSubscriptionNotCreatedButCreditCardStoredWithErrorsFromStripe.
     *
     * @return array
     */
    public function providerTestSubscriptionNotCreatedButCreditCardStoredWithErrorsFromStripe(): array
    {
        return [
            [
                [
                    'stripe_token' => 'tok_discover',
                    'expected_error' => 'home.credit_card_not_valid',
                    'card' => [
                        'last_four' => '9424',
                        'brand' => 'Discover',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_jcb',
                    'expected_error' => 'home.credit_card_not_valid',
                    'card' => [
                        'last_four' => '0000',
                        'brand' => 'JCB',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedFraudulent',
                    'expected_error' => 'home.credit_card_not_valid',
                    'card' => [
                        'last_four' => '0019',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeCustomerFail',
                    'expected_error' => 'home.credit_card_not_valid',
                    'card' => [
                        'last_four' => '0341',
                        'brand' => 'Visa',
                    ],
                ],
            ],
        ];
    }

    /**
     * Test that a user can't create more than one subscription.
     */
    public function testSubscriptionCanOnlyBeCreatedOnceError()
    {
        // Config
        $creditCard = [
            'stripe_token' => 'tok_es',
            'cardLastFour' => '0007',
            'cardBrand' => 'Visa',
        ];

        // Prepare
        list($user, $subscription) = TestUtils::createUserAndSubscription();

        $requestData = [
            'stripe_token' => $creditCard['stripe_token'],
        ];

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCreatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPageUrl);

        $response->assertSessionHasErrors(['subscription_error' => trans('home.subscription_already_active')]);

        // Check that the user has not been modified
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'stripe_id' => $user->stripe_id,
            'card_brand' => $user->card_brand,
            'card_last_four' => $user->card_last_four,
            'trial_ends_at' => null,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);

        // Check that the subscription has not been modified
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'stripe_id' => $subscription->stripe_id,
            'name' => $subscription->name,
            'stripe_plan' => $subscription->stripe_plan,
            'created_at' => $subscription->created_at,
            'updated_at' => $subscription->updated_at,
        ]);
    }

    /**
     * Test that the subscription validator throws errors when the data is not valid.
     *
     * @dataProvider providerTestCreateSubscriptionErrorValidation
     * @param array $requestData
     * @param array $validationErrorKeys
     */
    public function testCreateSubscriptionErrorValidation($requestData, $validationErrorKeys)
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCreatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPageUrl);

        $response->assertSessionHasErrors($validationErrorKeys);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'stripe_id' => null,
            'card_brand' => null,
            'card_last_four' => null,
            'trial_ends_at' => null,
        ]);

        $this->assertDatabaseMissing('subscriptions', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Provider for testCreateSubscriptionErrorValidation.
     *
     * @return array
     */
    public function providerTestCreateSubscriptionErrorValidation()
    {
        return [
            [
                'requestData' => [
                    'stripe_token' => null,
                ],
                'validationErrorKeys' => ['stripe_token',],
            ],
        ];
    }

    /**
     * Test that a user that is not authenticated can't create a subscription.
     */
    public function testCreateSubscriptionNotAuthorizedRedirectsToLogin()
    {
        // Request
        $response = $this->call('POST', $this->subscriptionCreatePostUrl, ['stripe_token' => 'xxx',]);

        // Asserts
        $response->assertRedirect('login');
    }

    /**
     * Test update credit card of a subscription.
     *
     * @dataProvider providerUpdateSubscriptionCardOk
     * @param array $example
     */
    public function testUpdateSubscriptionCardOk($example)
    {
        // Prepare
        list($user) = TestUtils::createUserAndSubscription([], [], true);

        $requestData = [
            'stripe_token' => $example['stripe_token'],
        ];

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCardUpdatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPaymentMethodPageUrl);
        $response->assertSessionHas('success', trans('home.subscription_card_updated'));

        // Database asserts
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'card_brand' => $example['card']['brand'],
            'card_last_four' => $example['card']['last_four'],
            'trial_ends_at' => null,
        ]);
    }

    /**
     * Data provider for testSubscriptionNotCreatedButCreditCardStoredWithErrorsFromStripe.
     *
     * @return array
     */
    public function providerUpdateSubscriptionCardOk(): array
    {
        return [
            [
                [
                    'stripe_token' => 'tok_mastercard',
                    'card' => [
                        'last_four' => '4444',
                        'brand' => 'MasterCard',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_amex',
                    'card' => [
                        'last_four' => '8431',
                        'brand' => 'American Express',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_visa',
                    'card' => [
                        'last_four' => '4242',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_riskLevelElevated',
                    'card' => [
                        'last_four' => '9235',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_bypassPending',
                    'card' => [
                        'last_four' => '0077',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_domesticPricing',
                    'card' => [
                        'last_four' => '0093',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_avsLine1Fail',
                    'card' => [
                        'last_four' => '0028',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_avsUnchecked',
                    'card' => [
                        'last_four' => '0044',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeCustomerFail',
                    'card' => [
                        'last_four' => '0341',
                        'brand' => 'Visa',
                    ],
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedFraudulent',
                    'card' => [
                        'last_four' => '0019',
                        'brand' => 'Visa',
                    ],
                ],
            ],
        ];
    }


    /**
     * Test that update subscription card throws validation errors.
     */
    public function testUpdateSubscriptionCardErrorValidation()
    {
        // Prepare
        $requestData = [
            'stripe_token' => '',
        ];

        list($user) = TestUtils::createUserAndSubscription();

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCardUpdatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPaymentMethodPageUrl);

        $response->assertSessionHasErrors(['validation' => trans('home.subscription_error_updating_card')]);
    }

    /**
     * Test that a card can't be updated if a user does not have an active subscription.
     */
    public function testUpdateNonActiveSubscriptionCreditCardError()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create();

        $requestData = [
            'stripe_token' => 'tok_visa',
        ];

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCardUpdatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPaymentMethodPageUrl);
        $response->assertSessionHasErrors(['subscription' => trans('home.subscription_needed_to_update_card')]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'card_brand' => null,
            'card_last_four' => null,
            'trial_ends_at' => null,
        ]);
    }

    /**
     * Test that updating a subscription card can throw error from Stripe.
     *
     * @dataProvider providerUpdateSubscriptionCreditCardWithStripeErrors
     * @param $example
     */
    public function testUpdateSubscriptionCardWithStripeErrors($example)
    {
        // Prepare
        $requestData = [
            'stripe_token' => $example['stripe_token'],
        ];

        list($user) = TestUtils::createUserAndSubscription([], [], true);

        // Request
        $response = $this->actingAs($user)->call('POST', $this->subscriptionCardUpdatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->subscriptionPaymentMethodPageUrl);
        $response->assertSessionHasErrors(['stripe_error' => trans($example['expected_error'])]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'card_brand' => $user->card_brand,
            'card_last_four' => $user->card_last_four,
            'trial_ends_at' => $user->trial_ends_at,
        ]);
    }

    /**
     * Data provider for updateSubscriptionCreditCardWithStripeErrors.
     *
     * @return array
     */
    public function providerUpdateSubscriptionCreditCardWithStripeErrors()
    {
        return [
            [
                [
                    'stripe_token' => 'tok_avsFail',
                    'expected_error' => 'home.incorrect_zip',
                ],
            ], [
                [
                    'stripe_token' => 'tok_avsZipFail',
                    'expected_error' => 'home.incorrect_zip',
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedExpiredCard',
                    'expected_error' => 'home.credit_card_expired',
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedProcessingError',
                    'expected_error' => 'home.stripe_processing_error',
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclined',
                    'expected_error' => 'home.credit_card_not_valid',
                ],
            ], [
                [
                    'stripe_token' => 'tok_chargeDeclinedIncorrectCvc',
                    'expected_error' => 'home.credit_card_cvv_incorrect',
                ],
            ], [
                [
                    'stripe_token' => 'tok_cvcCheckFail',
                    'expected_error' => 'home.credit_card_cvv_incorrect',
                ],
            ],
        ];
    }

    /**
     * Test that a user must be authenticated in order to update a subscription card.
     */
    public function testUpdateSubscriptionCardNotAuthenticatedRedirectsToLogin()
    {
        // Prepare
        $requestData = [
            'stripe_token' => 'tok_mastercard',
        ];

        // Request
        $response = $this->call('POST', $this->subscriptionCardUpdatePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->loginUrl);
    }

    /**
     * Test create subscription from registration page.
     */
    public function testRegisterUserAndCreateSubscriptionOk()
    {

    }
}
