<?php

namespace Rych\Random\Source;

use Rych\Random\Source;
use Rych\Random\Exception\UnsupportedSourceException;

class MCrypt implements Source
{

    public function __construct()
    {
        if (!extension_loaded('mcrypt')) {
            throw new UnsupportedSourceException('The mcrypt extension is not loaded');
        }
    }

    public function read($bytes)
    {
        return mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
    }

}
