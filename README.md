# Laravel Plain Beanstalk Queue

[![Total Downloads](https://poser.pugx.org/afsardo/plainqueue/downloads)](https://packagist.org/packages/afsardo/plainqueue)
[![Latest Stable Version](https://poser.pugx.org/afsardo/plainqueue/v/stable)](https://packagist.org/packages/afsardo/plainqueue)
[![Latest Unstable Version](https://poser.pugx.org/afsardo/plainqueue/v/unstable)](https://packagist.org/packages/afsardo/plainqueue)
[![License](https://poser.pugx.org/afsardo/plainqueue/license)](https://packagist.org/packages/afsardo/plainqueue)

This package is a replacement for Beanstalk driver that all it does is instead of poping jobs from the queue and resolving them into Laravel\Job classes they are just passed as plain data to a Listener Handler.
It was created due to the fact that Beanstalk driver ignores jobs that aren't resolved.

## Monolithic Application Context
Makes sense if you are connected to a Queue that external services are pushing jobs and you want to be able to fetch them.

## Service Oriented Architecture
When using the Queue to communicate with other services it is a **MUST** since this makes your services completely framework/language agnostic thus making them 100% independent.

# Installation Guide

## Install package

    composer require afsardo\plainqueue

## Setup your service provider

Go to your `config/app.php` and this line to your `providers => []`:

```php
<?php

/**
 * AFSardo Service Providers...
 */
AFSardo\PlainQueue\BeanstalkdPlainServiceProvider::class,
```

## Finally define your Listener

Go to your `app/Providers/AppServiceProvider.php` and add this line to your `register` function:

```php
<?php

/**
 * Register any application services.
 *
 * @return void
 */
public function register()
{
    $this->app->bind('AFSardo\PlainQueue\Contracts\BeanstalkdPlainJobListener', 'App\Listeners\MyListener');        
}
```

Your `App\Listeners\MyListener` should implement the `AFSardo\PlainQueue\Contracts\BeanstalkdPlainJobListener` interface and should look something like this:

```php
<?php

namespace App\Listeners;

use AFSardo\PlainQueue\Contracts\BeanstalkdPlainJobListener;

class MyListener {

	public function handle($payload) {	
		// do work with the ($payload)
	}

}
```

The payload is the job that was pushed to the Queue.

## When you are ready to use it

Just change the default beanstalkd driver in `config/queue.php`.

```php
<?php

'beanstalkd' => [
    'driver' => 'beanstalkd-plain',
],

```

You are all set!
