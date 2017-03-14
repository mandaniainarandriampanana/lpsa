<?php

namespace Lpsa\AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AjaxSelectTransformer implements DataTransformerInterface
{
    /**
     * @var DepotManagerInterface
     */
    protected $em;
    
    /**
     *
     * @var string 
     */
    protected $entityClass;

    /**
     * construct.
     *
     * @param DepotManagerInterface $em
     * @param string $entityClass
     */
    public function __construct(EntityManager $em,$entityClass)
    {
        $this->em = $em;
        $this->entityClass = $entityClass;
    }

    /**
     * Transforms an object (entity) to a string (value).
     *
     * @param Entity|null $value
     *
     * @return string
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return is_callable([$value, 'getId']) ? $value->getId() : '';
    }

    /**
     * Transforms a string (value) to an object (depot).
     *
     * @param string $value
     *
     * @return Entity|null
     *
     * @throws TransformationFailedException if object (Entity) is not found.
     */
    public function reverseTransform($value)
    {
        // no value? 
        if (!$value) {
            return;
        }
        $entity = $this->em->getRepository($this->entityClass)->findOneById($value);
        if (null === $entity) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An entity with number "%s" does not exist!',
                $value
            ));
        }

        return $entity;
    }
}
