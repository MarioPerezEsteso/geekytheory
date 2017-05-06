<?php

use App\Validators\SiteMetaValidator;
use App\Http\Controllers\SiteMetaController;
use Illuminate\Http\UploadedFile;

class SiteMetaValidatorTest extends TestCase
{
    /**
     * Test successful update with valid data.
     *
     * @dataProvider getValidData
     * @param array $data
     */
    public function testUpdateSuccess($data)
    {
        $validator = new SiteMetaValidator(App::make('validator'));
        $passes = $validator->update(SiteMetaController::getSiteMeta()->getAttributes('id'))->with($data)->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test unsuccessful update with invalid data.
     *
     * @dataProvider getInvalidData
     * @param array $data
     * @param array $validationErrorKeys
     */
    public function testUpdateFailure($data, $validationErrorKeys)
    {
        $validator = new SiteMetaValidator(App::make('validator'));
        $passes = $validator->update(SiteMetaController::getSiteMeta()->getAttributes('id'))->with($data)->passes();
        $this->assertFalse($passes);
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Test menu update success on post valid JSON.
     */
    public function testMenuUpdateSuccess()
    {
        $validator = new SiteMetaValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidMenu())->menuPasses());
    }

    /**
     * Test menu update failure on post invalid JSON.
     */
    public function testMenuUpdateFailure()
    {
        $validator = new SiteMetaValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidMenu())->menuPasses());
        $this->assertEquals(2, count($validator->errors()));
    }

    public function getValidMenu()
    {
        $menu = array(
            array(
                'text' => 'Item',
                'link' => 'http://laraweb.com',
                'submenu' => array(
                    array(
                        'text' => 'Submenu text',
                        'link' => 'http://laraweb.com/submenu',
                        'submenu' => null,
                    )
                )
            ),
            array(
                'text' => 'This is another item',
                'link' => 'http://laraweb.com/link',
                'submenu' => null,
            )
        );
        return $menu;
    }

    public function getInvalidMenu()
    {
        $menu = array(
            array(
                'link' => 'malfor med%%url.com',
                'submenu' => array(
                    array(
                        'text' => 'Submenu text',
                        'link' => 'http://another     malformedurl.com/submenu',
                        'submenu' => null,
                    )
                )
            ),
            array(
                'text' => 'This is another item',
                'link' => 'http://laraweb.com/link',
                'submenu' => null,
            )
        );
        return $menu;
    }

    /**
     * Returns valid data.
     *
     * @return array
     */
    public static function getValidData()
    {
        return [
            [
                [
                    'title' => 'Site title',
                    'subtitle' => 'new subtitle',
                    'description' => 'new description',
                    'url' => 'http://validurl.com',
                    'image' => UploadedFile::fake()->image('image.png'),
                    'logo' => UploadedFile::fake()->image('validextension.png'),
                    'favicon' => UploadedFile::fake()->image('valid.gif'),
                    'logo_57' => UploadedFile::fake()->image('image57.png'),
                    'logo_72' => UploadedFile::fake()->image('file.jpeg'),
                    'logo_114' => UploadedFile::fake()->image('image114.png'),
                    'twitter' => 'http://validurl.com',
                    'instagram' => 'http://insta.es',
                ]
            ],
            [
                [
                    'title' => 'Site title updated',
                    'subtitle' => 'new subtitle updated',
                    'description' => 'new wawa description',
                    'url' => 'https://geekytheory.com',
                    'image' => UploadedFile::fake()->image('image.png'),
                    'logo' => UploadedFile::fake()->image('validextension.jpg'),
                    'favicon' => UploadedFile::fake()->image('valid.gif'),
                    'twitter' => 'http://validurl.com',
                    'instagram' => 'http://insta.es',
                ]
            ],
        ];
    }

    /**
     * Returns invalid data.
     *
     * @return array
     */
    public static function getInvalidData()
    {
        return [
            [
                [
                    'title' => 'Site title updated',
                    'subtitle' => null,
                    'description' => 'Site description',
                    'url' => null,
                ],
                'validationErrorKeys' => ['subtitle', 'url'],
            ],
            [
                [
                    'title' => 'Site title updated',
                    'subtitle' => 'Random subtitle',
                    'description' => 'Site description',
                    'url' => null,
                ],
                'validationErrorKeys' => ['url'],
            ],
            [
                [
                    'title' => 'Site title',
                    'subtitle' => 'new subtitle',
                    'description' => 'new description',
                    'url' => 'invalid url',
                    'image' => UploadedFile::fake()->image('image.png'),
                    'logo' => UploadedFile::fake()->image('invalidextension.csv'),
                    'favicon' => UploadedFile::fake()->image('valid.jpg'),
                    'logo_57' => UploadedFile::fake()->image('image57.png'),
                    'logo_72' => UploadedFile::fake()->image('file.txt'),
                    'logo_114' => UploadedFile::fake()->image('image114.png'),
                    'twitter' => 'http://validurl.com',
                    'instagram' => 'this is not a valid url',
                ],
                'validationErrorKeys' => ['url', 'logo', 'logo_72', 'instagram'],
            ],
        ];
    }

    /**
     * Returns valid data with an image.
     *
     * @return array
     */
    public function getValidImage()
    {
        $file = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(10, 10), $file); // create and write image/png to it
        $image = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $file,
            'image.png',
            'image/png',
            null,
            null,
            true
        );
        return array(
            'title' => 'Site title updated',
            'subtitle' => 'Site subtitle',
            'description' => 'Site description',
            'image' => $image,
        );
    }

    /**
     * Returns data with an invalid file.
     *
     * @return array
     */
    public function getInvalidFile()
    {
        $image = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $file = tempnam(sys_get_temp_dir(), 'upl'),
            'test-file.csv',
            'text/plain',
            446,
            null,
            true
        );
        return array(
            'title' => 'Site title updated',
            'subtitle' => 'Site subtitle',
            'description' => 'Site description',
            'image' => $image,
        );
    }

}