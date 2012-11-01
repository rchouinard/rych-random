<?php

namespace Rych\Random\Source;

use Rych\Random\Source;
use Rych\Random\Exception\UnsupportedSourceException;

class URandom implements Source
{


    public function __construct()
    {
        if (!file_exists('/dev/urandom') || !is_readable('/dev/urandom')) {
            throw new UnsupportedSourceException('Cannot read from /dev/urandom');
        }
    }

    public function read($bytes)
    {
        return file_get_contents('/dev/urandom', false, null, 0, $bytes);
    }

}
