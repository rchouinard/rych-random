<?php

namespace Rych\Random\Source;

use Rych\Random\Source;
use Rych\Random\Exception\UnsupportedSourceException;

class MTRand implements Source
{

    public function __construct()
    {
    }

    public function read($bytes)
    {
        $output = '';
        while (strlen($output) < $bytes) {
            $block = '';
            for ($i = 0; $i < 64; ++$i) {
                $block .= chr((mt_rand() ^ mt_rand()) % 256);
            }
            $output .= sha1($block, true);
        }
        return substr($output, 0, $bytes);
    }

}
