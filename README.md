# BrauneDigitalPitcherBundle

<img src="http://www.pitcher-app.com/images/Pitcher-Logo-Pos-Big.png" width="400">

This bundle integrates the Pitcher component (https://github.com/braune-digital/BrauneDigitalPitcher) into the Symfony framework. It allows you to define parameters in your configuration and serves with a simple service for sending notifications to Pitcher.

## Installation

Require the bundle with composer:

```
composer require braune-digital/pitcher-bundle
```

Now you can add the bundle to AppKernel.php:

```
<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
        	...
            new BrauneDigital\PitcherBundle\BrauneDigitalPitcherBundle(),
            ...
        );
        ...
        return $bundles;
    }
    ...
}

```

## Configuration

Paste this configuration into your config.yml and add edit your parameters.yml (and parameters.yml.dist in case you are going to deploy your app):

```
imports:
    - { resource: @BrauneDigitalPitcherBundle/Resources/config/config.yml }
```

```
parameters:
	...
    braune_digital_pitcher.secret: SECRET_FROM PITCHER_APP // www.pitcher-app.com
    braune_digital_pitcher.satellite_name: YOU_ARE_FREE_TO_CHOOSE_A_NAME // for example: Projekt1
```


example configuration
```yaml
braune_digital_pitcher:
    threshold: 500
    ignore_exceptions:  # Default values, caution: will ignore extended errors as well
        - 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
        - 'Symfony\Component\Security\Core\Exception\AuthenticationException'
    handler: pitcher.handler.on_terminate
```

After that step you are ready to use the pitcher client.


## Using the client service

If the service container is available in your class you are able to use the service and pitch errors to Pitcher App.


```php
$this->getContainer()->get('pitcher.client')->pitch(Notification::LEVEL_CRITICAL, 'XML API from server B is down');
```


## Adding filters
Adding filters is very easy, just use the tag {name: pitcher.filter, order: 0} with the desired order (small values will be executed first)




```yaml
pitcher.filter.example:
    class: 'BrauneDigital\PitcherBundle\Filter\ExceptionFilter'
    arguments: [ 'DummyException']
    tags:
        - {name: pitcher.filter, order: 0}
```