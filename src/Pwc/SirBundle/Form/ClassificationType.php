<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassificationType extends AbstractType
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'L' => 'form.type.classification.low',
                'M' => 'form.type.classification.medium',
                'H' => 'form.type.classification.high'
            )
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'classification';
    }
}