# Rych Random Data Library

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-coveralls]][link-coveralls]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This library aims to provide a clean interface to generating cryptographically
secure random data in PHP 5.3+.


## Install

Via Composer

``` bash
$ composer require rych/random
```


## Usage

The library is easy to get up and running quickly. The best source of random
data available for your platform will be automatically selected and configured.

```php
<?php

$random = new Rych\Random\Random();

// Generate a 16-byte string of random raw data
$randomBytes = $random->getRandomBytes(16);

// Get a random integer between 1 and 100
$randomNumber = $random->getRandomInteger(1, 100);

// Get a random 8-character string using the
// character set A-Za-z0-9./
$randomString = $random->getRandomString(8);
```

If you prefer your random bytes delivered in hex format, we can do that too:

```php
<?php

$encoder = new Rych\Random\Encoder\HexEncoder();
$random = new Rych\Random\Random();
$random->setEncoder($encoder);

// Generate a 16-byte string of random raw data,
// encoded as a 32-character hex string
$randomBytes = $random->getRandomBytes(16);
```

### Generators

The library provides support for several CSPRNGs. The generator factory class
`Rych\Random\Generator\GeneratorFactory` can be used to automatically discover
and select the best available option for the current platform.

##### MCrypt (Rych\Random\Generator\MCryptGenerator)

MCrypt provides an interface to standard operating system CSPRNGs through the
`mcrypt_create_iv()` function. On Windows systems, this function will use the
Windows CryptoAPI, while other operating systems will read from `/dev/urandom`.
This backend requires PHP's MCrypt extension to be enabled.

This is the preferred backend, and will be selected by default if it is
available.

##### OpenSSL (Rych\Random\Generator\OpenSSLGenerator)

OpenSSL provides a CSPRNG through the `openssl_random_pseudo_bytes()` function.
Support for this backend requires that PHP's OpenSSL extension be available.
Windows servers also have the requirement of running PHP versions >= 5.3.7 due
to a bug in the PHP OpenSSL implementation which could cause the function to
perform slowly or even hang.

The OpenSSL backend is the second preferred backend, and will be selected if it
is available.

##### CAPICOM (Rych\Random\Generator\CapicomGenerator)

Although Microsoft has [deprecated the CAPICOM interface](http://blogs.msdn.com/b/karinm/archive/2009/01/19/capicom-dll-removed-from-windows-sdk-for-windows-7.aspx),
the library currently supports the old interface. Support requires running on
a Windows server with the COM extension enabled.

It should be noted that the MCrypt backend, if available, will use the newer
Windows CryptoAPI to access Windows' built-in CSPRNG. The OpenSSL backend will
do the same on PHP versions >= 5.4.0.

As CAPICOM is deprecated, it will only be selected if neither the MCrypt or
OpenSSL backends are available on Windows systems.

##### /dev/urandom (Rych\Random\Generator\URandomGenerator)

The built-in non-blocking CSPRNG on most non-Windows platforms is supported
by this backend. Support requires read-access to /dev/urandom on non-Windows
platforms.

This backend will only be selected if neither the MCrypt or OpenSSL backends are
available on non-Windows systems.

##### [George Argyros' clock drift algorithm](https://github.com/GeorgeArgyros/Secure-random-bytes-in-PHP) (Rych\Random\Generator\ClockDriftGenerator)

Systems which cannot use any of the above backends will use this one. It
provides a CSPRNG in pure PHP, although it is pretty slow.

This backend has no special requirements, and is therefore always available.


## Testing

``` bash
$ vendor/bin/phpunit -c phpunit.dist.xml
```


## Security

If you discover any security related issues, please email rchouinard@gmail.com instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/rych/random.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rchouinard/rych-random.svg?style=flat-square
[ico-coveralls]: https://img.shields.io/coveralls/rchouinard/rych-random.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/sensiolabs/i/e06088dc-30ea-4958-aa17-41254c36134e.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rych/random.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rych/random
[link-travis]: https://travis-ci.org/rchouinard/rych-random
[link-coveralls]: https://coveralls.io/r/rchouinard/rych-random
[link-code-quality]: https://insight.sensiolabs.com/projects/e06088dc-30ea-4958-aa17-41254c36134e
[link-downloads]: https://packagist.org/packages/rych/random
[link-author]: https://github.com/rchouinard
[link-contributors]: https://github.com/rchouinard/rych-random/graphs/contributors
