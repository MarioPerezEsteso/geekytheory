<?php

namespace Tests\Functional;

use App\Mail\ContactFormReceived;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormControllerTest extends TestCase
{
    /**
     * Coupon validation endpoint.
     *
     * @var string
     */
    protected $contactFormEndpoint = 'contacto';

    /**
     * Test send contact form ok.
     */
    public function testSendContactFormOk()
    {
        // Prepare
        $requestData = [
            'name' => 'Mario',
            'email' => 'nombre@dominio.com',
            'message' => 'This is just a contact form message :)',
            '_token' => 'mycsrftoken',
        ];

        Mail::fake();

        // Request
        $response = $this->withSession(['_token' => $requestData['_token']])
            ->call('POST', $this->contactFormEndpoint, $requestData);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect($this->contactFormEndpoint);
        $response->assertSessionHas('success', 'Tu mensaje ha sido enviado.');

        Mail::assertSent(ContactFormSubmitted::class, function ($mail) use ($requestData) {
            return $mail->name === $requestData['name'] &&
                $mail->formMessage === $requestData['message'] &&
                $mail->hasTo($requestData['email']);
        });

        Mail::assertSent(ContactFormReceived::class, function ($mail) use ($requestData) {
            return $mail->name === $requestData['name'] &&
                $mail->email === $requestData['email'] &&
                $mail->formMessage === $requestData['message'] &&
                $mail->hasTo(config('mail.contactform.notificationaddress'));
        });
    }

    /**
     * Test validation errors in contact form.
     */
    public function testSendContactWithValidationErrorsOk()
    {
        // Prepare
        $requestData = [
            'email' => 'incorrectEmail',
            '_token' => 'mycsrftoken',
        ];

        Mail::fake();

        // Request
        $response = $this->withSession(['_token' => $requestData['_token']])
            ->call('POST', $this->contactFormEndpoint, $requestData);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect($this->contactFormEndpoint);
        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors('formMessage');

        Mail::assertNotSent(ContactFormSubmitted::class);
        Mail::assertNotSent(ContactFormReceived::class);
    }
}
