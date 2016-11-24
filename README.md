## TBone

[![Latest Stable Version](https://poser.pugx.org/lukevear/tbone/v/stable)](https://packagist.org/packages/lukevear/tbone)
[![Build Status](https://travis-ci.org/lukevear/tbone.svg)](https://travis-ci.org/lukevear/tbone)
[![Coverage Status](https://coveralls.io/repos/lukevear/tbone/badge.svg?branch=master&service=github)](https://coveralls.io/github/lukevear/tbone?branch=master)
[![License](https://poser.pugx.org/lukevear/tbone/license)](https://packagist.org/packages/lukevear/tbone)


## A very simple, very fast PHP router.

 * Exceptionally easy to use
 * Supports OPTIONS, HEAD, GET, POST, PUT, PATCH and DELETE requests
 * Simple event system for error handling

> Note: TBone does not support route parameters (such as /customers/{id})

### When to use TBone
TBone is designed to be used in in very simple, relatively static PHP applications where your application logic can sit within a set of closures. If you try to use TBone for anything beyond simple sites, you're going to have a bad time. If you're after something more impressive I would suggest [nikic/FastRoute](https://github.com/nikic/FastRoute).

### Installation

```
composer require lukevear/tbone
```

### Activating the router
You may use TBone wherever you feel is appropiate in your project, however the most common usage would be in an index.php file in your document directory. If running from an index.php file, you should have a .htaccess file similar to the one below.

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Basic Example
 
~~~PHP
use TBone\TBone;

$router = new TBone;

// Add a GET route
$router->get('/', function() {
    echo 'Welcome to my homepage';
});

// Add a POST route
$router->post('/contact-us', function() {
    echo 'Thanks for your submission';
});

// Run the router
$router->dispatch();
~~~

### Event System
TBone's event system exists to provide a mechanism for you to handle routing related events. TBone supports `ROUTE_DISPATCH_REQUESTED` (fired when dispatch() is called), `ROUTE_NOT_FOUND` (fired when a route cannot be matched) and `ROUTE_DISPATCHED` (fired when a route is matched and the callback has been run).

When an event is fired the specified callback will be run.

~~~PHP
use TBone\TBone;
use TBone\TBoneEvent;

$router = new TBone;

// Add a GET route
$router->get('/', function() {
    echo 'Welcome to my homepage';
});

// Register our 404 page
$router->addHandler(TBoneEvent::ROUTE_NOT_FOUND, function() {
    http_response_code(404);
    echo 'Sorry, that page doesn\'t exist!';
});

// Run the router
$router->dispatch();
~~~
