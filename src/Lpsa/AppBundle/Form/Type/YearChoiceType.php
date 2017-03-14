<?php

namespace Lpsa\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

class YearChoiceType extends AbstractType{
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'year_choice'
        ]);
        $choices = function (Options $options){
            $aChoices = array();
            if(empty($options['year_choice'])){
                for($year = date('Y');$year <= date('Y') + 10;$year++){
                    $aChoices[$year] = $year;
                }
            } else {
                for($year = $options['year_choice'];$year <= date('Y') + 10;$year++){
                    $aChoices[$year] = $year;
                }
            }
            return $aChoices;
        };
        
        $resolver->setDefaults([
            'choices' => $choices
        ]);
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'lpsa_year_choice';
    }
    
}
