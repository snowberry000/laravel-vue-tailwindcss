<?php
namespace App\Utilities;

class Image
{

    public function __invoke($id)
    {
        $firstDirectory = $this->getDirectoryName(24, $id);
        $secondDirectory = $this->getDirectoryName(12, $id);

        return env('THUMB_PATH', 'https: //thumbs.yayimages.com') . sprintf("/rz_200x200/%s/%s/%s.jpg", $firstDirectory, $secondDirectory, dechex($id));
    }

    protected function getDirectoryName($val, $fileId)
    {
        $shift = $val;
        $mask = 0;

        for ($i = 0; $i < $val; $i++) {
            $mask++;
            if ($i + 1 < $val) {
                $mask <<= 1;
            }
        }

        return dechex(($fileId >> $shift) & $mask);
    }
}