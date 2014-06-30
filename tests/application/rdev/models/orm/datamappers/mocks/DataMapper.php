<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Mocks the data mapper class for use in testing
 */
namespace RDev\Tests\Models\ORM\DataMappers\Mocks;
use RDev\Models;
use RDev\Models\ORM\Exceptions;
use RDev\Models\ORM\DataMappers;

class DataMapper implements DataMappers\IDataMapper
{
    /** @var Models\IEntity[] The list of entities added */
    private $entities = [];
    /** @var int The current Id */
    private $currId = 0;

    /**
     * {@inheritdoc}
     */
    public function add(Models\IEntity &$entity)
    {
        $this->currId++;
        $entity->setId($this->currId);
        $this->entities[$entity->getId()] = $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Models\IEntity &$entity)
    {
        unset($this->entities[$entity->getId()]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return array_values($this->entities);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        if(!isset($this->entities[$id]))
        {
            throw new Exceptions\ORMException("No entity found with Id " . $id);
        }

        return $this->entities[$id];
    }

    /**
     * @return int
     */
    public function getCurrId()
    {
        return $this->currId;
    }

    /**
     * {@inheritdoc}
     */
    public function loadEntity(array $hash)
    {
        // Don't do anything
    }

    /**
     * {@inheritdoc}
     */
    public function update(Models\IEntity &$entity)
    {
        $this->entities[$entity->getId()] = $entity;
    }
} 