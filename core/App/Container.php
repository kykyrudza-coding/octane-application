<?php

namespace Kernel\Application;

use Exception;

/**
 * Class Container
 *
 * A simple Dependency Injection Container.
 * It allows registering and retrieving services by their names.
 */
class Container
{
    /**
     * Array of registered services.
     */
    protected array $services = [];

    /**
     * Constructor.
     *
     * Initializes the container with an array of services.
     *
     * @param  array  $services  An associative array of services to register.
     */
    public function __construct(array $services = [])
    {
        foreach ($services as $name => $service) {
            $this->set($name, $service);
        }
    }

    /**
     * Retrieves a service by its name.
     *
     * @param  string  $name  The name of the service.
     * @return mixed The service instance or the result of the callable.
     *
     * @throws Exception If the service is not found.
     */
    public function get(string $name): mixed
    {
        if (! isset($this->services[$name])) {
            throw new Exception(
                'Service not found: '.$name,
                404
            );
        }

        $service = $this->services[$name];

        return is_callable($service) ? $service() : $service;
    }

    /**
     * Registers a service in the container.
     *
     * @param  string  $name  The name of the service.
     * @param  callable|object  $service  The service instance or a callable that returns it.
     */
    public function set(string $name, callable|object $service): void
    {
        $this->services[$name] = $service;
    }
}
