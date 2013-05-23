Rych Random Data Library
========================

This library aims to provide a clean interface to generating cryptographically
secure random data in PHP 5.3+.

[![Build Status](https://travis-ci.org/rchouinard/rych-random.png?branch=master)](https://travis-ci.org/rchouinard/rych-random)
[![Coverage Status](https://coveralls.io/repos/rchouinard/rych-random/badge.png?branch=master)](https://coveralls.io/r/rchouinard/rych-random)

Quick Start
-----------

The library is easy to get up and running quickly. The best source of random
data available for your platform will be automatically selected and configured.

```php
<?php

$random = new Rych\Random\Random;

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

$encoder = new Rych\Random\Encoder\HexEncoder;
$random = new Rych\Random\Random;
$random->setEncoder($encoder);

// Generate a 16-byte string of random raw data,
// encoded as a 32-character hex string
$randomBytes = $random->getRandomBytes(16);
```


Installation via [Composer](http://getcomposer.org/)
------------

 * Install Composer to your project root:
    ```bash
    curl -sS https://getcomposer.org/installer | php
    ```

 * Add a `composer.json` file to your project:
    ```json
    {
      "require" {
        "rych/random": "1.0.*@dev"
      }
    }
    ```

 * Run the Composer installer:
    ```bash
    php composer.phar install
    ```


Generators
----------

The library uses a set of generator classes which wrap various sources of random
data. By default, the main class will use a generator factory to select the best
available generator, but if you prefer to specify one that works too.

A generator class must implement `Rych\Random\Generator\GeneratorInterface` and
may be passed in to the main class either as the first argument to the
constructor or via the `setGenerator()` method.


### Supported Generators

The library provides support for several CSPRNGs. The generator factory class
`Rych\Random\Generator\GeneratorFactory` can be used to automatically discover
and select the best available option for the current platform.

#### MCrypt (Rych\Random\Generator\MCryptGenerator)

MCrypt provides an interface to standard operating system CSPRNGs through the
`mcrypt_create_iv()` function. On Windows systems, this function will use the
Windows CryptoAPI, while other operating systems will read from `/dev/urandom`.
This backend requires PHP's MCrypt extension to be enabled.

This is the preferred backend, and will be selected by default if it is
available.

#### OpenSSL (Rych\Random\Generator\OpenSSLGenerator)

OpenSSL provides a CSPRNG through the `openssl_random_pseudo_bytes()` function.
Support for this backend requires that PHP's OpenSSL extension be available.
Windows servers also have the requirement of running PHP versions >= 5.3.7 due
to a bug in the PHP OpenSSL implementation which could cause the function to
perform slowly or even hang.

The OpenSSL backend is the second preferred backend, and will be selected if it
is available.

#### CAPICOM (Rych\Random\Generator\CapicomGenerator)

Although Microsoft has [deprecated the CAPICOM interface](http://blogs.msdn.com/b/karinm/archive/2009/01/19/capicom-dll-removed-from-windows-sdk-for-windows-7.aspx),
the library currently supports the old interface. Support requires running on
a Windows server with the COM extension enabled.

It should be noted that the MCrypt backend, if available, will use the newer
Windows CryptoAPI to access Windows' built-in CSPRNG. The OpenSSL backend will
do the same on PHP versions >= 5.4.0.

As CAPICOM is deprecated, it will only be selected if neither the MCrypt or
OpenSSL backends are available on Windows systems.

#### /dev/urandom (Rych\Random\Generator\URandomGenerator)

The built-in non-blocking CSPRNG on most non-Windows platforms is supported
by this backend. Support requires read-access to /dev/urandom on non-Windows
platforms.

This backend will only be selected if neither the MCrypt or OpenSSL backends are
available on non-Windows systems.

#### [George Argyros' clock drift algorithm](https://github.com/GeorgeArgyros/Secure-random-bytes-in-PHP) (Rych\Random\Generator\ClockDriftGenerator)

Systems which cannot use any of the above backends will use this one. It
provides a CSPRNG in pure PHP, although it is pretty slow.

This backend has no special requirements, and is therefore always available.
