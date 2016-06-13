<?php

class CategoryCreateValidatorTest extends TestCase
{

    protected $file;
    protected $image;

    public function testCreateSuccess()
    {
        $validator = new \App\Validators\CategoryCreateValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    public function testCreateFailure()
    {
        $validator = new \App\Validators\CategoryCreateValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->passes());
        $this->assertEquals(2, count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
    }

    private function getValidCreateData()
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
            'category'  => 'Category',
            'slug'      => 'category-slug',
            'image'     => $image,
        );
    }

    public function getInvalidCreateData()
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
            'category'  => 'Category',
            'image'     => $image
        );
    }

}
