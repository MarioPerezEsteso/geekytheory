<?php

use App\Http\Controllers\UserController;

class UserControllerUnitTest extends TestCase
{
    /**
     * Test UserController::formatUsername
     *
     * @dataProvider getUnformattedUsernames
     * @return void
     */
    public function testFormatUsernameMethod($username, $expected)
    {
        $usernameFormatted = UserController::formatUsername($username);
        $this->assertEquals($expected, $usernameFormatted);
    }

    /**
     * Get unformatted usernames and their expected value after formatting them
     *
     * @return array
     */
    public static function getUnformattedUsernames()
    {
        return [
            [
                'username' => 'Aitor Tilla',
                'expected' => 'AitorTilla'
            ],
            [
                'username' => 'Aitor.Tilla',
                'expected' => 'AitorTilla'
            ],
            [
                'username' => 'Aitor__Tilla',
                'expected' => 'AitorTilla'
            ],
            [
                'username' => 'Aitor__Tilla.123',
                'expected' => 'AitorTilla123'
            ],
            [
                'username' => 'Aitor Tilla - 123',
                'expected' => 'AitorTilla123'
            ],
            [
                'username' => 'Aitor Tilla De Jamón',
                'expected' => 'AitorTillaDeJamon'
            ],
            [
                'username' => 'áéíóúàèìòù 10 Vocales con Acentos',
                'expected' => 'aeiouaeiou10VocalesconAcentos'
            ],
        ];
    }
}