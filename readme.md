# Temporal Tokens for Laravel

This package generates temporary tokens to use with your models, urls, controllers or whatever you want.

## Installation

Use composer to install:

```sh
composer require ericlagarda/temporal
```

Add provider to your `config/app.php`

```php
EricLagarda\Temporal\TemporalServiceProvider::class
```

`Temporal` facade  is automatically registered as an alias for `EricLagarda\Temporal\Facades\Temporal` class.



### How to use

You have two helpers to create and recieve temporal urls. 

To create your token just call `create` method:

```php
$myToken = Temporal::create($modelId, $expireTime); //$expireTime in minutes to expire
```

To decrypt this token and check if is valid, you can use `check` method:

```php
$isValid = Temporal::check($token); //$token appended to url
```

Method `check` will return `false` in case token is invalid. Or object with `id`, `expires`, `created_at` if is valid.


### License

The MIT License (MIT).
