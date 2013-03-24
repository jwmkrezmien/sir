<?php

namespace Pwc\SirBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextTypeExtension extends AbstractTypeExtension
{

    /**
    * Returns the name of the type being extended.
    *
    * @return string The name of the type being extended
    */
    public function getExtendedType()
    {
        return 'text';
    }

    /**
     * Add the select2 rendering option
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                        'attr'    => array('class' => 'sir input-block-level')
                    ));
    }
}