<?php

class ImageManagerControllerTest extends TestCase
{

    public function testGetUploadFilename()
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

        $fileName = \App\Http\Controllers\ImageManagerController::getUploadFilename($image);
        $this->assertEquals('image.png', $fileName);
    }


}
