<?php

namespace App;

/**
 * Class Container
 *
 * This class is responsible for managing service registrations and
 * dependency injection in the application.
 *
 * @author Rashadul Shaon <codershaon@gmail.com>
 * @date 2025-01-23
 */
class Container
{
    private array $manualServices = [];
    private array $serviceAliases = [];

    public function __construct(
        private array $excludedAutowires = []
    ) {}

    public function set(string $name, callable $resolver)
    {
        $this->manualServices[$name] = $resolver;
    }

    public function get(string $name)
    {
        if (isset($this->manualServices[$name])) {
            return $this->manualServices[$name]($this);
        }

        return $this->autowire($name);
    }

    /**
     * Adds a service alias to the container.
     *
     * This allows a service identified by the original name to be 
     * accessed using the replacement name.
     *
     * @param string $original The original service name.
     * @param string $replacement The alias name for the service.
     */
    public function addServiceAlias(string $original, string $replacement)
    {
        $this->serviceAliases[$original] = $replacement;
    }

    /**
     * Tries to autowire an instance of the given class.
     *
     * @param string $class
     * @return object
     * @throws \Exception
     */
    public function autowire(string $class)
    {
        foreach ($this->excludedAutowires as $namespace) {
            if (strpos($class, $namespace) === 0) {
                throw new \Exception("Class $class is not autowirable.");
            }
        }

        if (isset($this->serviceAliases[$class])) {
            $class = $this->serviceAliases[$class];
        }

        try {
            $reflection = new \ReflectionClass($class);
            $constructor = $reflection->getConstructor();

            if (is_null($constructor)) {
                return new $class;
            }

            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                $dependencyClass = $parameter->getType()->getName();
                if (isset($this->serviceAliases[$dependencyClass])) {
                    $dependencyClass = $this->serviceAliases[$dependencyClass];
                }
                $dependencies[] = $this->get($dependencyClass);
            }

            return $reflection->newInstanceArgs($dependencies);
        } catch (\ReflectionException $e) {
            throw new \Exception("Failed to autowire class: $class.");
        }
    }
}
