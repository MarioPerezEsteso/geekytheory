<?php

namespace Tests\Functional;

use App\User;
use Tests\Helpers\TestConstants;
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
            'subscription_plan' => $example['subscriptionPlan'],
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
            'name' => $example['subscriptionPlan'] === 'monthly' ? TestConstants::MODEL_SUBSCRIPTION_PLAN_MONTHLY_NAME : TestConstants::MODEL_SUBSCRIPTION_PLAN_YEARLY_NAME,
            'stripe_plan' => $example['subscriptionPlan'],
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
    public function providerTestCreateSubscriptionOk()
    {
        return [
            [
                [
                    'stripeToken' => 'tok_visa',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '4242',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_visa_debit',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '5556',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '4444',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard_debit',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '8210',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard_prepaid',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '5100',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_amex',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '8431',
                    'cardBrand' => 'American Express',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mx',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '0008',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_es',
                    'subscriptionPlan' => 'monthly',
                    'cardLastFour' => '0007',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_visa',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '4242',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_visa_debit',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '5556',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '4444',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard_debit',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '8210',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mastercard_prepaid',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '5100',
                    'cardBrand' => 'MasterCard',
                ]
            ], [
                [
                    'stripeToken' => 'tok_amex',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '8431',
                    'cardBrand' => 'American Express',
                ]
            ], [
                [
                    'stripeToken' => 'tok_mx',
                    'subscriptionPlan' => 'yearly',
                    'cardLastFour' => '0008',
                    'cardBrand' => 'Visa',
                ]
            ], [
                [
                    'stripeToken' => 'tok_es',
                    'subscriptionPlan' => 'yearly',
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
            'subscription_plan' => 'monthly',
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
    public function providerTestSubscriptionNotCreatedAndCreditCardNotStoredWithErrorsFromStripe()
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
            'subscription_plan' => 'monthly',
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
     * @return void
     */
    public function providerTestSubscriptionNotCreatedButCreditCardStoredWithErrorsFromStripe()
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
            ],[
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
    }

    /**
     * Test that the subscription validator throws errors when the data is not valid.
     */
    public function testCreateSubscriptionErrorValidation()
    {
    }

    /**
     * Test that a user that is not authenticated can't create a subscription.
     */
    public function testCreateSubscriptionNotAuthorizedRedirectsToLogin()
    {
    }

    /**
     * Test create subscription from registration page.
     */
    public function testRegisterUserAndCreateSubscriptionOk()
    {
    }

    /**
     *
     */
    public function updateSubscriptionFromMonthlyToYearlyOk()
    {
    }

    /**
     *
     */
    public function updateSubscriptionFromYearlyToMonthlyOk()
    {
    }

    /**
     *
     */
    public function updateSubscriptionNotAuthorizedRedirectsToLogin()
    {
    }
}
