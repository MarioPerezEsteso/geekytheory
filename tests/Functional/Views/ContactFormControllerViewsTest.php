<?php

namespace Tests\Functional\Views;

use App\User;
use Carbon\Carbon;
use Tests\Helpers\Response;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class ContactFormControllerViewsTest extends TestCase
{
    /**
     * Contact form page URL.
     *
     * @var string
     */
    protected $contactFormPageUrl = 'contacto';

    /**
     * Test visit contact form page ok.
     */
    public function testVisitContactFormPageOk()
    {
        // Request
        $response = $this->call('GET', $this->contactFormPageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('web.contact');
    }
}
