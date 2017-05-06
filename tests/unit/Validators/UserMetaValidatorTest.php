<?php

use \App\Validators\UserMetaValidator;

class UserMetaValidatorTest extends TestCase
{
    /**
     * Test create with valid data.
     */
    public function testCreateSuccess()
    {
        $validator = new UserMetaValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    /**
     * Test create with invalid data.
     */
    public function testCreateFailure()
    {
        $validator = new UserMetaValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->passes());
        $this->assertEquals(6, count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
    }

    /**
     * Test update with valid data.
     */
    public function testUpdateSuccess()
    {
        $validator = new UserMetaValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->update()->passes());
    }

    /**
     * Test update with invalid data.
     */
    public function testUpdateFailure()
    {
        $validator = new UserMetaValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->update()->passes());
        $this->assertEquals(6, count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
    }

    /**
     * Returns an array with an example of valid data.
     * 
     * @return array
     */
    private function getValidCreateData()
    {
        return [
            'biography' => 'Engineer. Passionate about technology. Open source lover.',
            'job' => 'Cloud developer',
            'twitter' => 'https://twitter.com/username',
            'instagram' => 'https://instagram.com/username',
            'facebook' => 'https://facebook.com/username',
            'github' => 'https://github.com/username',
            'youtube' => 'https://youtube.com/username',
            'googleplus' => 'https://plus.google.com/username',
            'stackoverflow' => 'https://stackoverflow.com/profileurl',
            'bitbucket' => 'https://bitbucket.org/username',
            'linkedin' => 'https://www.linkedin.com/in/username',
            'tumblr' => 'http://username.tumblr.com/',
            'twitch' => 'https://www.twitch.tv/username',
            'vimeo' => 'https://vimeo.com/username',
        ];
    }

    /**
     * Returns an array with an example of invalid data.
     * 
     * @return array
     */
    private function getInvalidCreateData()
    {
        return [
            'biography' => "Engineer. Passionate about technology. Open source lover. This biography is really long and should not be validated. \
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sollicitudin pharetra nunc, at facilisis mi sagittis vel. \
                            Acme Phasellus ultricies turpis ac dui convallis semper. Mauris at maximus volutpat.", // Will fail
            'job' => 'Cloud developer',
            'twitter' => '@marioperest', // Will fail
            'instagram' => '@iliketopostfoodpics', // Will fail
            'facebook' => 'https://facebook.com/geekytheory',
            'github' => 'https://github.com/marioperezesteso',
            'youtube' => 'https://youtube.com/telecoreference',
            'googleplus' => '+geekytheory', // Will fail
            'stackoverflow' => 'https://stackoverflow.com/arandomurl',
            'bitbucket' => 'https://bitbucket.org/geekytheory',
            'linkedin' => 'https://www.linkedin.com/in/marioperezesteso',
            'tumblr' => 'I do not have a Tumblr. I have Geeky Theory!', // Will fail
            'twitch' => 'Neither twitch. But I would like to.', // Will fail
            'vimeo' => 'https://vimeo.com/arandomuser',
        ];
    }
}