<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController;

class StripeWebhookController extends WebhookController
{
    /**
     * {@inheritdoc}
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        // @TODO: notify subscription cancelled to webmaster.
        return parent::handleCustomerSubscriptionDeleted($payload);
    }
}
