<?php
/**
 * Image file tool
 */
namespace Tool;

class ImageTool
{

    /**
     * Change the direction of picture
     * @param $picAddr
     */
    public static function imgOrientate($picAddress){
        $exif = exif_read_data($picAddress);
        $image = imagecreatefromjpeg($picAddress);
        if($exif['Orientation'] == 3) {
            $result = imagerotate($image, 180, 0);
            imagejpeg($result, $picAddress, 100);
        } elseif($exif['Orientation'] == 6) {
            $result = imagerotate($image, -90, 0);
            imagejpeg($result, $picAddress, 100);
        } elseif($exif['Orientation'] == 8) {
            $result = imagerotate($image, 90, 0);
            imagejpeg($result, $picAddress, 100);
        }
        isset($result) && imagedestroy($result);
        imagedestroy($image);
    }
}