<?php

require __DIR__ . '/../vendor/autoload.php';

defined('RYCH_RANDLIB_BASEDIR')
    || define('RYCH_RANDLIB_BASEDIR', realpath(__DIR__ . '/../src'));

defined('RYCH_RANDLIB_TESTDIR')
    || define('RYCH_RANDLIB_TESTDIR', realpath(__DIR__ . '/../test'));
