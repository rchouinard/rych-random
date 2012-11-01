<?php

namespace Rych\Random\Source;

use Rych\Random\Source;
use Rych\Random\Exception\UnsupportedSourceException;

class OpenSSL implements Source
{

    public function __construct()
    {
        if (!extension_loaded('openssl')) {
            throw new UnsupportedSourceException('The openssl extension is not loaded');
        }
    }

    public function read($bytes)
    {
        return openssl_random_pseudo_bytes($bytes);
    }

}
