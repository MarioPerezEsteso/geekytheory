<?php

use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * Test method that creates slugs from texts.
     *
     * @dataProvider getTextsToSlugify
     * @param string $text
     * @param string $expected
     */
    public function testSlugify($text, $expected)
    {
        $slug = slugify($text);
        $this->assertEquals($slug, $expected);
    }

    /**
     * Test method that formats seconds to hh:mm:ss.
     *
     * @dataProvider getSecondsToFormat
     * @param $seconds
     * @param $expectedFormat
     */
    public function testFormatSeconds($seconds, $expectedFormat)
    {
        $secondsFormatted = formatSeconds($seconds);
        $this->assertEquals($expectedFormat, $secondsFormatted);
    }

    /**
     * Get seconds to format and their expected values.
     *
     * @return array
     */
    public static function getSecondsToFormat()
    {
        return [
            ['seconds' => 5, 'expectedFormat' => '00:05',],
            ['seconds' => 0, 'expectedFormat' => '00:00',],
            ['seconds' => 65, 'expectedFormat' => '01:05',],
            ['seconds' => 320, 'expectedFormat' => '05:20',],
            ['seconds' => 3920, 'expectedFormat' => '01:05:20',],
        ];
    }

    /**
     * Get texts to slugify and their expected values
     *
     * @return array
     */
    public static function getTextsToSlugify()
    {
        return [
            [
                'text' => 'Título de un artículo cualquiera',
                'expected' => 'titulo-de-un-articulo-cualquiera',
            ],
            [
                'text' => '¿Tiene este artículo interrogaciones?',
                'expected' => 'tiene-este-articulo-interrogaciones',
            ],
            [
                'text' => 'AIDE: desarrollo de aplicaciones Android desde Android',
                'expected' => 'aide-desarrollo-de-aplicaciones-android-desde-android',
            ],
            [
                'text' => 'AIDE: desarrollo de aplicaciones Android desde Android',
                'expected' => 'aide-desarrollo-de-aplicaciones-android-desde-android',
            ],
            [
                'text' => 'Aprende Flask [Parte 1] - Introducción y Hola Mundo',
                'expected' => 'aprende-flask-parte-1-introduccion-y-hola-mundo',
            ],
            [
                'text' => 'Curso Scala [Parte 1]: ¿Qué es Scala?',
                'expected' => 'curso-scala-parte-1-que-es-scala',
            ],
            [
                'text' => '#DdaysArena 2015',
                'expected' => 'ddaysarena-2015',
            ],
            [
                'text' => 'Guión_bajo',
                'expected' => 'guion-bajo',
            ],
        ];
    }
}