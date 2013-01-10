<?php

namespace Pwc\SirBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Util\PropertyPath;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;

class EntityTypeExtension extends AbstractTypeExtension
{

    /**
    * Returns the name of the type being extended.
    *
    * @return string The name of the type being extended
    */
    public function getExtendedType()
    {
        return 'entity';
    }

    /**
     * Add the select2 rendering option
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                        'select2' => true,
                    ))
                 ->setAllowedTypes(array(
                        'select2' => array('bool')
                    ));


        $resolver->setDefaults(array(
            'attr' => function (Options $options, $attributes) {

                if($options['select2'])
                {
                    if (!empty($attributes) && array_key_exists('class', $attributes))
                    {
                        $attributes['class'] .= ' alter-select2';
                    }else{

                        $attributes['class'] = 'alter-select2';

                    }
                }

                return $attributes;

            },
        ));

    }

    /**
     * Pass the select2 url to the view
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('select2', $options))
        {

        }
    }
}