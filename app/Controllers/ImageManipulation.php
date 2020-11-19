<?php namespace App\Controllers;

use App\Controllers\BaseController;

class ImageManipulation extends BaseController
{

    public function image_fit()
    {
        $image = \Config\Services::image()
            ->withFile(WRITEPATH . 'uploads/movies/5/1575128863_4acadf20ebe48354c5c3.png')
            ->fit(100, 100, 'center')
            ->save(WRITEPATH . 'uploads/imagemanipulation/image_fit.png');

    }

    public function image_rotate()
    {
        $image = \Config\Services::image()
            ->withFile(WRITEPATH . 'uploads/movies/5/1575128863_4acadf20ebe48354c5c3.png')
            ->rotate(270)
            ->save(WRITEPATH . 'uploads/imagemanipulation/image_rotate.png');

    }

    public function image_resize()
    {
        $image = \Config\Services::image()
            ->withFile(WRITEPATH . 'uploads/movies/5/1575128863_4acadf20ebe48354c5c3.png')
            ->resize(100, 100,false)
            ->save(WRITEPATH . 'uploads/imagemanipulation/image_resize.png');

    }

    public function image_quality()
    {
        $image = \Config\Services::image()
            ->withFile(WRITEPATH . 'uploads/movies/5/1575128863_4acadf20ebe48354c5c3.png')
            ->fit(300, 300, 'center')
            ->save(WRITEPATH . 'uploads/imagemanipulation/image_quality.png', 15);

    }

    public function image_crop()
    {
        /* $info = \Config\Services::image('imagick')
        ->withFile(WRITEPATH.'uploads/movies/5/1575128863_4acadf20ebe48354c5c3.png')
        ->getFile()
        ->getProperties(true);

        $xOffset = ($info['width'] / 2) - 25;
        $yOffset = ($info['height'] / 2) - 25;*/

        $xOffset = 100;
        $yOffset = 100;

        $image = \Config\Services::image()
            ->withFile(WRITEPATH . 'uploads/movies/5/1575128863_4acadf20ebe48354c5c3.png')
            ->crop(50, 50, $xOffset, $yOffset)
            ->save(WRITEPATH . 'uploads/imagemanipulation/image_crop.png');
    }

}
