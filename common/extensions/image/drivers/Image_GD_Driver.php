<?php

/**
 * GD Image Driver.
 *
 * $Id: GD.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Image
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Image_GD_Driver extends Image_Driver
{

    // A transparent PNG as a string
    protected static $blank_png;
    protected static $blank_png_width;
    protected static $blank_png_height;

    public function __construct()
    {
        // Make sure that GD2 is available
        if (!function_exists('gd_info'))
            throw new CException('Image component requires GD');

        // Get the GD information
        $info = gd_info();

        // Make sure that the GD2 is installed
        if (strpos($info['GD Version'], '2.') === FALSE)
            throw new CException('Image component requires GD v2');
    }

    public function process($image, $actions, $dir, $file, $render = FALSE)
    {
        // Set the "create" function
        switch ($image['type']) {
            case IMAGETYPE_JPEG:
                $create = 'imagecreatefromjpeg';
                $save = 'imagejpeg';
                break;
            case IMAGETYPE_GIF:
                $create = 'imagecreatefromgif';
                $save = 'imagegif';
                break;
            case IMAGETYPE_PNG:
                $create = 'imagecreatefrompng';
                $save = 'imagepng';
                break;
            case IMAGETYPE_BMP:
                $create = 'ImageCreateFromBMP';
                $save = 'imagejpeg';
                break;
        }

        // Set the "save" function
        switch (strtolower(substr(strrchr($file, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $save = 'imagejpeg';
                break;
            case 'gif':
                $save = 'imagegif';
                break;
            case 'png':
                $save = 'imagepng';
                break;
            case 'bmp':
                $save = 'imagejpeg';
                break;
        }

        // Make sure the image type is supported for import
        if (empty($create) or !function_exists($create))
            throw new CException('image type not allowed');

        // Make sure the image type is supported for saving
        if (empty($save) or !function_exists($save))
            throw new CException('image type not allowed');

        // Load the image
        $this->image = $image;

        // Create the GD image resource
        $this->tmp_image = $create($image['file']);

        // Get the quality setting from the actions
        $quality = null;
        if (array_key_exists('quality', $actions)) {
            $quality = $actions['quality'];
            unset($actions['quality']);
        }

        if ($status = $this->execute($actions)) {
            // Prevent the alpha from being lost
            imagealphablending($this->tmp_image, true);
            imagesavealpha($this->tmp_image, true);

            switch ($save) {
                case 'imagejpeg':
                    // Default the quality to 95
                    ($quality === NULL) and $quality = 95;
                    break;
                case 'imagegif':
                    // Remove the quality setting, GIF doesn't use it
                    unset($quality);
                    break;
                case 'imagepng':
                    // Always use a compression level of 9 for PNGs. This does not
                    // affect quality, it only increases the level of compression!
                    $quality = 9;
                    break;
            }

            if ($render === false) {
                // Set the status to the save return value, saving with the quality requested
                $status = isset($quality)
                    ? $save($this->tmp_image, $dir . $file, $quality)
                    : $save($this->tmp_image, $dir . $file);
            } else {
                // Output the image directly to the browser
                switch ($save) {
                    case 'imagejpeg':
                        header('Content-Type: image/jpeg');
                        break;
                    case 'imagegif':
                        header('Content-Type: image/gif');
                        break;
                    case 'imagepng':
                        header('Content-Type: image/png');
                        break;
                }

                $status = isset($quality)
                    ? $save($this->tmp_image, NULL, $quality)
                    : $save($this->tmp_image);
            }

            // Destroy the temporary image
            imagedestroy($this->tmp_image);
        }

        return $status;
    }

    public function flip($direction)
    {
        // Get the current width and height
        $width = imagesx($this->tmp_image);
        $height = imagesy($this->tmp_image);

        // Create the flipped image
        $flipped = $this->imagecreatetransparent($width, $height);
        $status = false;
        switch ($direction) {
            case Image::HORIZONTAL:
                for ($x = 0; $x < $width; $x++) {
                    $status = imagecopy($flipped, $this->tmp_image, $x, 0, $width - $x - 1, 0, 1, $height);
                }
                break;
            case Image::VERTICAL:
                for ($y = 0; $y < $height; $y++) {
                    $status = imagecopy($flipped, $this->tmp_image, 0, $y, 0, $height - $y - 1, $width, 1);
                }
                break;
            default:
                return true;
        }

        if ($status === true) {
            // Swap the new image for the old one
            imagedestroy($this->tmp_image);
            $this->tmp_image = $flipped;
        }

        return $status;
    }

    public function crop($properties)
    {
        // Sanitize the cropping settings
        $this->sanitize_geometry($properties);

        // Get the current width and height
        $width = imagesx($this->tmp_image);
        $height = imagesy($this->tmp_image);

        // Create the temporary image to copy to
        $img = $this->imagecreatetransparent($properties['width'], $properties['height']);

        // Execute the crop
        if ($status = imagecopyresampled($img, $this->tmp_image, 0, 0, $properties['left'], $properties['top'], $width, $height, $width, $height)) {
            // Swap the new image for the old one
            imagedestroy($this->tmp_image);
            $this->tmp_image = $img;
        }

        return $status;
    }

    public function resize($properties)
    {
        // Get the current width and height
        $width = imagesx($this->tmp_image);
        $height = imagesy($this->tmp_image);

        if (substr($properties['width'], -1) === '%') {
            // Recalculate the percentage to a pixel size
            $properties['width'] = round($width * (substr($properties['width'], 0, -1) / 100)+0.5);
        }

        if (substr($properties['height'], -1) === '%') {
            // Recalculate the percentage to a pixel size
            $properties['height'] = round($height * (substr($properties['height'], 0, -1) / 100)+0.5);
        }

        // Recalculate the width and height, if they are missing
        empty($properties['width'])  and $properties['width'] = round($width * $properties['height'] / $height+0.5);
        empty($properties['height']) and $properties['height'] = round($height * $properties['width'] / $width+0.5);

        if ($properties['master'] === Image::AUTO) {
            // Change an automatic master dim to the correct type
            $properties['master'] = (($width / $properties['width']) > ($height / $properties['height']))
                ? Image::WIDTH
                : Image::HEIGHT;
        }

        if (empty($properties['height']) or $properties['master'] === Image::WIDTH) {
            // Recalculate the height based on the width
            $properties['height'] = round($height * $properties['width'] / $width+0.5);
        }

        if (empty($properties['width']) or $properties['master'] === Image::HEIGHT) {
            // Recalculate the width based on the height
            $properties['width'] = round($width * $properties['height'] / $height+0.5);
        }

        // Test if we can do a resize without resampling to speed up the final resize
        if ($properties['width'] > $width / 2 and $properties['height'] > $height / 2) {
            // Presize width and height
            $pre_width = $width;
            $pre_height = $height;

            // The maximum reduction is 10% greater than the final size
            $max_reduction_width = round($properties['width'] * 1.1);
            $max_reduction_height = round($properties['height'] * 1.1);

            // Reduce the size using an O(2n) algorithm, until it reaches the maximum reduction
            while ($pre_width / 2 > $max_reduction_width and $pre_height / 2 > $max_reduction_height) {
                $pre_width /= 2;
                $pre_height /= 2;
            }

            // Create the temporary image to copy to
            $img = $this->imagecreatetransparent($pre_width, $pre_height);

            if ($status = imagecopyresized($img, $this->tmp_image, 0, 0, 0, 0, $pre_width, $pre_height, $width, $height)) {
                // Swap the new image for the old one
                imagedestroy($this->tmp_image);
                $this->tmp_image = $img;
            }

            // Set the width and height to the presize
            $width = $pre_width;
            $height = $pre_height;
        }

        // Create the temporary image to copy to
        $img = $this->imagecreatetransparent($properties['width'], $properties['height']);

        // Execute the resize
        if ($status = imagecopyresampled($img, $this->tmp_image, 0, 0, 0, 0, $properties['width'], $properties['height'], $width, $height)) {
            // Swap the new image for the old one
            imagedestroy($this->tmp_image);
            $this->tmp_image = $img;
        }

        return $status;
    }

    public function rotate($amount)
    {
        // Use current image to rotate
        $img = $this->tmp_image;

        // White, with an alpha of 0
        $transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);

        // Rotate, setting the transparent color
        $img = imagerotate($img, 360 - $amount, $transparent, -1);

        // Fill the background with the transparent "color"
        imagecolortransparent($img, $transparent);

        // Merge the images
        if ($status = imagecopymerge($this->tmp_image, $img, 0, 0, 0, 0, imagesx($this->tmp_image), imagesy($this->tmp_image), 100)) {
            // Prevent the alpha from being lost
            imagealphablending($img, true);
            imagesavealpha($img, true);

            // Swap the new image for the old one
            imagedestroy($this->tmp_image);
            $this->tmp_image = $img;
        }

        return $status;
    }

    public function sharpen($amount)
    {
        // Make sure that the sharpening function is available
        if (!function_exists('imageconvolution'))
            throw new CException('image unsupported method');

        // Amount should be in the range of 18-10
        $amount = round(abs(-18 + ($amount * 0.08)), 2);

        // Gaussian blur matrix
        $matrix = array
        (
            array(-1, -1, -1),
            array(-1, $amount, -1),
            array(-1, -1, -1),
        );

        // Perform the sharpen
        return imageconvolution($this->tmp_image, $matrix, $amount - 8, 0);
    }

    public function grayscale($unused)
    {
        return imagefilter($this->tmp_image, IMG_FILTER_GRAYSCALE);
    }

    public function colorize($params)
    {
        return imagefilter($this->tmp_image, IMG_FILTER_COLORIZE, $params['r'], $params['g'], $params['b'], $params['a']);
    }

    public function emboss($unused)
    {
        return imagefilter($this->tmp_image, IMG_FILTER_EMBOSS);
    }

    public function negate($unused)
    {
        return imagefilter($this->tmp_image, IMG_FILTER_NEGATE);
    }

    protected function properties()
    {
        return array(imagesx($this->tmp_image), imagesy($this->tmp_image));
    }

    /**
     * Returns an image with a transparent background. Used for rotating to
     * prevent unfilled backgrounds.
     *
     * @param   integer  image width
     * @param   integer  image height
     * @return  resource
     */
    protected function imagecreatetransparent($width, $height)
    {
        if (self::$blank_png === NULL) {
            // Decode the blank PNG if it has not been done already
            self::$blank_png = imagecreatefromstring(base64_decode
            (
                'iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29' .
                    'mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAADqSURBVHjaYvz//z/DYAYAAcTEMMgBQAANegcCBN' .
                    'CgdyBAAA16BwIE0KB3IEAADXoHAgTQoHcgQAANegcCBNCgdyBAAA16BwIE0KB3IEAADXoHAgTQoHcgQ' .
                    'AANegcCBNCgdyBAAA16BwIE0KB3IEAADXoHAgTQoHcgQAANegcCBNCgdyBAAA16BwIE0KB3IEAADXoH' .
                    'AgTQoHcgQAANegcCBNCgdyBAAA16BwIE0KB3IEAADXoHAgTQoHcgQAANegcCBNCgdyBAAA16BwIE0KB' .
                    '3IEAADXoHAgTQoHcgQAANegcCBNCgdyBAgAEAMpcDTTQWJVEAAAAASUVORK5CYII='
            ));

            // Set the blank PNG width and height
            self::$blank_png_width = imagesx(self::$blank_png);
            self::$blank_png_height = imagesy(self::$blank_png);
        }

        $img = imagecreatetruecolor($width, $height);

        // Resize the blank image
        imagecopyresized($img, self::$blank_png, 0, 0, 0, 0, $width, $height, self::$blank_png_width, self::$blank_png_height);

        // Prevent the alpha from being lost
        imagealphablending($img, FALSE);
        imagesavealpha($img, TRUE);

        return $img;
    }

    public function watermark($params)
    {
        $path = $params['path'];
        $x = $params['x'];
        $y = $params['y'];
        imagealphablending($this->tmp_image, true);
        imagesavealpha($this->tmp_image, true);
        $mark = imagecreatefrompng($path);
        imagecopyresized($this->tmp_image, $mark, $x, $y, 0, 0, imagesx($mark), imagesy($mark), imagesx($mark), imagesy($mark));
        imagedestroy($mark);
        return $this->tmp_image;
    }
} // End Image GD Driver

function ImageCreateFromBMP($filename)
{
    //Ouverture du fichier en mode binaire
    if (! $f1 = fopen($filename,"rb")) return FALSE;

    //1 : Chargement des ent�tes FICHIER
    $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
    if ($FILE['file_type'] != 19778) return FALSE;

    //2 : Chargement des ent�tes BMP
    $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
    '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
    '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
    $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
    if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
    $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
    $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
    $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
    $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
    $BMP['decal'] = 4-(4*$BMP['decal']);
    if ($BMP['decal'] == 4) $BMP['decal'] = 0;

    //3 : Chargement des couleurs de la palette
    $PALETTE = array();
    if ($BMP['colors'] < 16777216)
    {
        $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
    }

    //4 : Cr�ation de l'image
    $IMG = fread($f1,$BMP['size_bitmap']);
    $VIDE = chr(0);

    $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
    $P = 0;
    $Y = $BMP['height']-1;
    while ($Y >= 0)
    {
        $X=0;
        while ($X < $BMP['width'])
        {
            if ($BMP['bits_per_pixel'] == 24)
                $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
            elseif ($BMP['bits_per_pixel'] == 16)
            {
                $COLOR = unpack("n",substr($IMG,$P,2));
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            elseif ($BMP['bits_per_pixel'] == 8)
            {
                $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            elseif ($BMP['bits_per_pixel'] == 4)
            {
                $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
                if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            elseif ($BMP['bits_per_pixel'] == 1)
            {
                $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
                if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
                elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
                elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
                elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
                elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
                elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
                elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
                elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            else
                return FALSE;
            imagesetpixel($res,$X,$Y,$COLOR[1]);
            $X++;
            $P += $BMP['bytes_per_pixel'];
        }
        $Y--;
        $P+=$BMP['decal'];
    }

    //Fermeture du fichier
    fclose($f1);

    return $res;
}