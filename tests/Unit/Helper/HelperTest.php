<?php

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
        ];
    }
}