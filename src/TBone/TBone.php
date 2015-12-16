<?php namespace TBone;

class TBone {

    /**
     * A list of routes that the router can respond to
     *
     * @var array
     */
    private $routes = [
        'get'=> [],
        'post'=> [],
        'put'=> [],
        'delete'=> [],
    ];

    /**
     * A list of callbacks to run if an event is fired
     *
     * @var array
     */
    private $eventHandlers = [];

    /**
     * Add a route that can respond to a GET request
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     * @throws TBoneException
     */
    public function get($route, $callback) {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['get'][$route] = $callback;
    }

    /**
     * Add a route that can respond to a POST request
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     * @throws TBoneException
     */
    public function post($route, $callback) {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['post'][$route] = $callback;
    }

    /**
     * Add a route that can respond to a PUT request
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     * @throws TBoneException
     */
    public function put($route, $callback) {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['put'][$route] = $callback;
    }

    /**
     * Add a route that can respond to a DELETE request
     *
     * @param $route string The URL to match
     * @param $callback callable The callback to run
     * @throws TBoneException
     */
    public function delete($route, $callback) {
        if (!is_callable($callback)) {
            throw new TBoneException('The callback that was provided is not callable.');
        }

        $this->routes['delete'][$route] = $callback;
    }

    /**
     * Add a handler for the specified event
     *
     * @param $event
     * @param $handler
     * @throws TBoneException
     */
    public function addHandler($event, $handler) {
        if (!is_callable($handler)) {
            throw new TBoneException('The handler provided is not callable.');
        }

        $this->eventHandlers[] = [
            'event' => $event,
            'handler' => $handler,
        ];
    }

    /**
     * Add an event handler
     *
     * @param $event int The event to match
     */
    private function fireEvent($event)
    {
        foreach($this->eventHandlers as $handler) {
            if ($handler['event'] === $event) {
                call_user_func($handler['handler']);
            }
        }
    }

    /**
     * Run the router
     */
    public function route()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if (!in_array($_SERVER['REQUEST_URI'], array_keys($this->routes[$method]))) {
            $this->fireEvent(TBoneEvent::ROUTE_NOT_FOUND);
            return;
        }

        call_user_func($this->routes[$method][$_SERVER['REQUEST_URI']]);
    }
}