<?php
/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
*/

Route::post(
    config('services.stripe.webhookRoute'),
    'StripeWebhookController@handleWebhook'
);