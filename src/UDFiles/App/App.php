<?php

namespace UDFiles\App;


class App
{
    /**
     * Current version
     * @var string
     */
    const VERSION = '0.1';

    /**
     * Container
     * @var array|Container
     */
    private $container;

    /**
     * App constructor.
     * @param array $container
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        $this->container = $container;
    }

    /**
     * Return the Container
     * @return array|Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get settings app
     * @param $key
     * @return array|mixed
     */
    public function getSetting($key = '')
    {
        return $this->container->getSetting($key);
    }
}