<?php

namespace TBone;

class TBone
{
    /**
     * A list of routes that the router can respond to.
     *
     * @var array
     */
    private $routes = [
        'OPTIONS'   => [],
        'HEAD'      => [],
        'GET'       => [],
        'POST'      => [],
        'PUT'       => [],
        'PATCH'     => [],
        'DELETE'    => [],
    ];

    /**
     * A list of callbacks to run if an event is fired.
     *
     * @var array
     */
    private $eventHandlers = [];

    /**
     * Add a route that can respond to a OPTIONS request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function options($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['OPTIONS'][$route] = $callback;

        return true;
    }

    /**
     * Add a route that can respond to a HEAD request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function head($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['HEAD'][$route] = $callback;

        return true;
    }

    /**
     * Add a route that can respond to a GET request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function get($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['GET'][$route] = $callback;

        return true;
    }

    /**
     * Add a route that can respond to a POST request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function post($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['POST'][$route] = $callback;

        return true;
    }

    /**
     * Add a route that can respond to a PUT request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function put($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['PUT'][$route] = $callback;

        return true;
    }

    /**
     * Add a route that can respond to a PATCH request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function patch($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['PATCH'][$route] = $callback;

        return true;
    }

    /**
     * Add a route that can respond to a DELETE request.
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function delete($route, $callback)
    {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['DELETE'][$route] = $callback;

        return true;
    }

    /**
     * Add a handler for the specified event.
     *
     * @param $event
     * @param $handler
     *
     * @throws TBoneException
     *
     * @return bool
     */
    public function addHandler($event, $handler)
    {
        if (!is_callable($handler)) {
            throw new TBoneException('The handler provided is not callable.');
        }

        $this->eventHandlers[] = [
            'event'   => $event,
            'handler' => $handler,
        ];

        return true;
    }

    /**
     * Add an event handler.
     *
     * @param $event int The event to match
     */
    private function fireEvent($event)
    {
        foreach ($this->eventHandlers as $handler) {
            if ($handler['event'] === $event) {
                call_user_func($handler['handler']);
            }
        }
    }

    /**
     * Run the router.
     */
    public function dispatch()
    {
        // Let the world know that we're dispatching
        $this->fireEvent(TBoneEvent::ROUTE_DISPATCH_REQUESTED);

        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']][strtok($_SERVER['REQUEST_URI'], '?')])) {
            $this->fireEvent(TBoneEvent::ROUTE_NOT_FOUND);
            return;
        }

        call_user_func($this->routes[$_SERVER['REQUEST_METHOD']][strtok($_SERVER['REQUEST_URI'], '?')]);

        // Let the world know that we're finished
        $this->fireEvent(TBoneEvent::ROUTE_DISPATCHED);
    }
}
