![Pitcher logo](./Pitcher-Logo-Pos-Big.png?raw=true "Title")
# BrauneDigitalPitcherBundle
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

After that step you are ready to use the pitcher client.


## Using the client service

If the service container is available in your class you are able to use the service and pitch errors to Pitcher App.


```php
$this->getContainer()->get('pitcher.client')->pitch(Notification::LEVEL_CRITICAL, 'XML API from server B is down');
```
