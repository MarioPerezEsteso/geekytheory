<?php

namespace Tests\Functional;

use \App\Http\Controllers\FeedController;
use DateTime;
use SimpleXMLElement;
use Tests\TestCase;

class RedirectionControllerTest extends TestCase
{
    /**
     * Test URL redirections.
     * @dataProvider providerTestRedirections
     * @param $fromUrl
     * @param $toUrl
     */
    public function testRedirections($fromUrl, $toUrl)
    {
        // Request
        $response = $this->call('GET', $fromUrl);

        // Assert
        $response->assertRedirect($toUrl);
        $response->assertStatus(301);
    }

    public function providerTestRedirections()
    {
        return [
            [
                'introduccion-a-python-instalacion-y-hola-mundo',
                'curso/python-3/como-instalar-python-3-windows-linux-mac',
            ], [
                'operadores-y-tipos-en-python',
                'curso/python-3/operadores-basicos',
            ], [
                'variables-en-python',
                'curso/python-3/variables-tipos',
            ], [
                'definicion-funciones-python',
                'curso/python-3/como-definir-funciones',
            ], [
                'bucles-en-python',
                'curso/python-3/bucles-while',
            ], [
                'la-funcion-range-en-python',
                'curso/python-3/bucles-for',
            ], [
                'como-crear-una-lista-de-tareas-con-laravel-tutorial-php',
                'curso/laravel',
            ],
        ];
    }
}