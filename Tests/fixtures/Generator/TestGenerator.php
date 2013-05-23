<?php

namespace My\Custom\Generator;

use Rych\Random\Generator\GeneratorInterface;

class TestGenerator implements GeneratorInterface
{

    public function generate($size)
    {
        return str_repeat(chr(0), $size);
    }

    public static function isSupported()
    {
        return true;
    }

    public static function getPriority()
    {
        return GeneratorInterface::PRIORITY_HIGH;
    }

}
