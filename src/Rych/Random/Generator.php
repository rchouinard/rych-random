<?php

namespace Rych\Random;

use Rych\Random\Source;

class Generator
{

    private $source;

    public function __construct(Source $source = null)
    {
        $this->source = $source;
    }

    public function setSource(Source $source)
    {
        $this->source = $source;
    }

    public function getSource()
    {
        // Kind of a hack for now; this needs to be more dynamic.
        if (!$this->source) {
            if (extension_loaded('openssl')) {
                $this->source = new \Rych\Random\Source\OpenSSL;
            } else if (extension_loaded('mcrypt')) {
                $this->source = new \Rych\Random\Source\MCrypt;
            } else if (is_readable('/dev/urandom')) {
                $this->source = new \Rych\Random\Source\URandom;
            } else {
                $this->source = new \Rych\Random\Source\MTRand;
            }
        }

        return $this->source;
    }

    public function generate($bytes)
    {
        $source = $this->getSource();
        return $source->read($bytes);
    }

}
