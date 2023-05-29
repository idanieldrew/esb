<p>
    <img src="art/logo.png" alt="esb">
</p>
    <p>
        <a href="https://packagist.org/packages/pestphp/pest"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/idanieldrew/esb"></a>
        <a href="https://packagist.org/packages/idanieldrew/esb"><img alt="Latest Version" src="https://img.shields.io/packagist/stars/idanieldrew/esb"></a>
        <a href="https://packagist.org/packages/pestphp/pest"><img alt="License" src="https://img.shields.io/packagist/l/idanieldrew/esb"></a>
    </p>

Esb support Pub/Sub in php and also support queue driver for Laravel.

* [Installation](#installation)
* [Usage](#usage)
    * [Quick start](#quick-start)
        * [Publish](#publish)
        * [Consume](#consume)

## Installation

Install with composer

```
composer require idanieldrew/esb
```

To publish the config

```
php artisan vendor:publish
```

and then select "esb-config" tag

## Usage

### Quick start

#### Publish

Publish messages with default exchange

```
use Idanieldrew\Esb\Facades\Esb;

// Publish message to queue
Esb::publish('queue','message'); 

```

#### Consume

Consume messages with default exchange

```
use Idanieldrew\Esb\Facades\Esb;

// Consume messages from queue
Esb::consume('queue', function ($message, $res) {
            var_dump($message->body);
        });
```

Consume messages from default queue in esb-config:

```
use Idanieldrew\Esb\Facades\Esb;

Esb::consume('', function ($message, $res) {
            var_dump($message->body);
        });
```

