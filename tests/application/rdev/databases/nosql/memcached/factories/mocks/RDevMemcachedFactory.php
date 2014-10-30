<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Defines the factory that creates mock Memcached objects for use in testing
 */
namespace RDev\Tests\Databases\NoSQL\Memcached\Factories\Mocks;
use RDev\Databases\NoSQL\Memcached;
use RDev\Databases\NoSQL\Memcached\Configs;
use RDev\Databases\NoSQL\Memcached\Factories;
use RDev\Tests\Databases\NoSQL\Memcached\Mocks;

class RDevMemcachedFactory extends Factories\RDevMemcachedFactory
{
    /**
     * {@inheritdoc}
     * @return Mocks\RDevMemcached The instantiated Memcached
     */
    public function createFromConfig(Configs\ServerConfig $config)
    {
        $typeMapper = new Memcached\TypeMapper();
        $memcached = new Mocks\RDevMemcached($typeMapper);

        /** @var Memcached\Server $server */
        foreach($config["servers"] as $server)
        {
            $memcached->addServer($server->getHost(), $server->getPort(), $server->getWeight());
        }

        return $memcached;
    }
} 