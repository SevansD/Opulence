<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Defines the Cache data mapper implemented by the Predis library
 */
namespace RDev\ORM\DataMappers;
use RDev\Databases\NoSQL\Redis;

abstract class PredisDataMapper extends RedisDataMapper
{
    /** @var Redis\RDevPredis The Redis cache to use for queries */
    protected $redis = null;

    /**
     * {@inheritdoc}
     */
    protected function getSetMembersFromRedis($key)
    {
        return $this->redis->smembers($key);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSortedSetMembersFromRedis($key)
    {
        return $this->redis->zrange($key, 0, -1);
    }

    /**
     * {@inheritdoc}
     */
    protected function getValueFromRedis($key)
    {
        return $this->redis->get($key);
    }
} 