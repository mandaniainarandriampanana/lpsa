<?php

namespace Lpsa\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class TextToEntityDataTransformer implements DataTransformerInterface
{
    private $manager;
    
    /**
     *
     * @var string 
     */
    protected $entityClass;

    public function __construct(ObjectManager $manager,$entityClass)
    {
        $this->manager = $manager;
        $this->entityClass = $entityClass;
    }
    
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return $value->getLabelToPrint();
    }
    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }
        if (!is_string($value)) {
            throw new TransformationFailedException('Contenu du champ invalide.');
        }
        $entity = $this->manager->getRepository($this->entityClass)->findOneById($value);
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