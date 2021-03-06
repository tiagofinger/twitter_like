<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class DocumentsTweetHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate($document, $data, array $hints = array())
    {
        $hydratedData = array();

        /** @Field(type="id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = $value instanceof \MongoId ? (string) $value : $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="integer") */
        if (isset($data['userTwitter'])) {
            $value = $data['userTwitter'];
            $return = (int) $value;
            $this->class->reflFields['userTwitter']->setValue($document, $return);
            $hydratedData['userTwitter'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['message'])) {
            $value = $data['message'];
            $return = (string) $value;
            $this->class->reflFields['message']->setValue($document, $return);
            $hydratedData['message'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['datetime'])) {
            $value = $data['datetime'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['datetime']->setValue($document, clone $return);
            $hydratedData['datetime'] = $return;
        }

        /** @Field(type="integer") */
        if (isset($data['likes'])) {
            $value = $data['likes'];
            $return = (int) $value;
            $this->class->reflFields['likes']->setValue($document, $return);
            $hydratedData['likes'] = $return;
        }
        return $hydratedData;
    }
}