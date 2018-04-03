# Elastic APM: PHP Agent

[![Build Status](https://travis-ci.org/hotrush/elastic-apm-php-agent.svg?branch=master)](https://travis-ci.org/hotrush/elastic-apm-php-agent)

This is a PHP agent for Elastic.co's APM product: https://www.elastic.co/solutions/apm. Please note that this agent is still **experimental** and not ready for any production usage.

**Note:** This is fork. Original package repository - [philkra/elastic-apm-php-agent](https://github.com/philkra/elastic-apm-php-agent)

## Installation
The recommended way to install the agent is through [Composer](http://getcomposer.org).

Run the following composer command

```bash
php composer.phar require hotrush/elastic-apm-php-agent
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Usage

### Initialize the Agent with minimal Config
```php
$agent = new \Hotrush\Agent(['appName' => 'demo']);
```
When creating the agent, you can directly inject shared contexts registry. Contexts registry contains info about user, request, tags and custom. 
```php
$contexts = new \Hotrush\Context\ContextsRegistry();
$contexts->getUser()
    ->setId(123)
    ->setUsername('User')
    ->setEmail('email@domain.com');
$contexts->getTags()->addTag('tag_name', 'tag_value');
$contexts->getRequest()->setRequestData(['body' => ['foo' => 'bar']]);
$contexts->getCustom()->addCustom('custom_key', [
    'id' => 1,
    'name' => 'Hello',
]);
$agent = new \Hotrush\Agent([ 'appName' => 'with-custom-context' ], $contexts);
```

### Capture Errors and Exceptions
The agent can capture all types or errors and exceptions that are implemented from the interface `Throwable` (http://php.net/manual/en/class.throwable.php).
```php
$agent->captureThrowable( new Exception() );
```

### Transaction without minimal Meta data and Context
```php
$trxName = 'Demo Simple Transaction';
$agent->startTransaction($trxName);
// Do some stuff you want to watch ...
$agent->stopTransaction($trxName);
```

### Transaction with Meta data and Contexts
```php
$trxName = 'Demo Transaction with more Data';
$agent->startTransaction($trxName);
// Do some stuff you want to watch ...
$agent->stopTransaction($trxName, [
    'result' => '200',
    'type'   => 'demo'
]);
$agent->getTransaction($trxName)->getContextsRegistry()->getUser()->setId(123);
$agent->getTransaction($trxName)->getContextsRegistry()->getTags()->addTag('tag', 'value');
$agent->getTransaction($trxName)->getContextsRegistry()->getTags()->setTags( [ 'k1' => 'v1', 'k2' => 'v2' ] );  
```

## Tests
```bash
vendor/bin/phpunit
```
