<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SiteMetaController;
use App\Subscriber;
use Illuminate\Support\Facades\Mail;

class SubscriberEmailController extends Controller
{
    /**
     * Notify users that they have to confirm their subscription.
     *
     * @param Subscriber $subscriber
     * @return bool
     */
    public static function sendConfirmationEmail($subscriber)
    {
        $siteMeta = SiteMetaController::getSiteMeta();
        $siteTitle = $siteMeta->title;
        $confirmationUrl = $siteMeta->url . '/newsletter/confirm/' . $subscriber->token;

        $data = [
            'subject' => trans('email.confirm_your_email_address_in_site', ['sitetitle' => $siteTitle]),
            'siteTitle' => $siteTitle,
            'confirmationUrl' => $confirmationUrl,
            'to' => $subscriber->email,
        ];

        Mail::send('themes.vortex.emails.newsletter.confirmSubscription', $data, function ($message) use ($data) {
            $message->from('no-reply@geekytheory.com', $data['siteTitle']);
            $message->to($data['to']);
            $message->subject($data['subject']);
        });

        return true;
    }

    /**
     * Notify users that their subscription has been confirmed.
     *
     * @param Subscriber $subscriber
     * @return bool
     */
    public static function sendSubscriptionConfirmedEmail($subscriber)
    {
        $siteMeta = SiteMetaController::getSiteMeta();
        $siteTitle = $siteMeta->title;

        $data = [
            'subject' => trans('email.you_have_confirmed_your_email_in_site', ['sitetitle' => $siteTitle]),
            'siteTitle' => $siteTitle,
            'to' => $subscriber->email,
        ];

        Mail::send('themes.vortex.emails.newsletter.subscriptionConfirmed', $data, function ($message) use ($data) {
            $message->from('no-reply@geekytheory.com', $data['siteTitle']);
            $message->to($data['to']);
            $message->subject($data['subject']);
        });

        return true;
    }
}
