Rych Random Generator
=====================

This library aims to provide a clean method to generate cryptographically secure
random data in PHP 5.3+.

Build status: [![Build Status](https://travis-ci.org/rchouinard/rych-random.png?branch=master)](https://travis-ci.org/rchouinard/rych-random)

Quick Start
-----------

```php
<?php
$generator = new Rych\Random\Generator;

// Generate a 16-byte string of random raw data
$randomBytes = $generator->generate(16);
```

Supported Backends
------------------

The library provides support for several CSPRNGs. The `Rych\Random\Factory`
class can determine which are supported on your server and return the best
available.

### MCrypt (Rych\Random\Source\MCrypt)

MCrypt provides an interface to standard operating system CSPRNGs through the
`mcrypt_create_iv()` function. On Windows systems, this function will use the
Windows CryptoAPI, while other operating systems will read from `/dev/urandom`.
This backend requires PHP's MCrypt extension to be enabled.

This is the preferred backend, and will be selected by default if it is
available.

### OpenSSL (Rych\Random\Source\OpenSSL)

OpenSSL provides a CSPRNG through the `openssl_random_pseudo_bytes()` function.
Support for this backend requires that PHP's OpenSSL extension be available.
Windows servers also have the requirement of running PHP versions >= 5.3.7 due
to a bug in the PHP OpenSSL implementation which could cause the function to
perform slowly or even hang.

The OpenSSL backend is the second preferred backend, and will be selected if it
is available.

### CAPICOM (Rych\Random\Source\CAPICOM)

Although Microsoft has [deprecated the CAPICOM interface](http://blogs.msdn.com/b/karinm/archive/2009/01/19/capicom-dll-removed-from-windows-sdk-for-windows-7.aspx),
the library currently supports the old interface. Support requires running on
a Windows server with the COM extension enabled.

It should be noted that the MCrypt backend, if available, will use the newer
Windows CryptoAPI to access Windows' built-in CSPRNG. The OpenSSL backend will
do the same on PHP versions >= 5.4.0.

As CAPICOM is deprecated, it will only be selected if neither the MCrypt or
OpenSSL backends are available on Windows systems.

### /dev/urandom (Rych\Random\Source\URandom)

The built-in non-blocking CSPRNG on most non-Windows platforms is supported
by this backend. Support requires read-access to /dev/urandom on non-Windows
platforms.

This backend will only be selected if neither the MCrypt or OpenSSL backends are
available on non-Windows systems.

### [George Argyros' clock drift algorithm](https://github.com/GeorgeArgyros/Secure-random-bytes-in-PHP) (Rych\Random\Source\ClockDrift)

Systems which cannot use any of the above backends will use this one. It
provides a CSPRNG in pure PHP, although it is pretty slow.

This backend has no special requirements, and is therefore always available.