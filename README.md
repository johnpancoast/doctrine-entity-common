# php-common

**This lib is defunct. The only things here that ever saw use were the common
entity interfaces. All other code was supplemented by other packages. I've left
it here for reference.**

Common functionality for my PHP apps

*Note that due to my idiocy I versioned this as a public v1 too early.* In the
eyes of [semver](http://semver.org/), it matters since the API is public and
it's changing a lot, regardless of the fact that nobody uses this besides me =P.
**Due to this, all versions below version 7 should be considered as version 0.
Version 7.0.0 will be the official public API.**

## Install

This project uses [composer](https://getcomposer.org/) for package management. Go there for details on how packages work.

You can either run this:

```bash
composer require johnpancoast/php-common
```

Or you can put this in inside the `require` block in your `composer.json` file then run `composer update`:

```json
{
  "require": {
    "johnpancoast/php-common": "^6.1"
  }
}
```

*Make sure to look at the versions, v7 is first public release*.

## todo
* Tests... I'm busy... I know, I know...
