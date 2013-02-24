<?php

namespace Pwc\SirBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\FormView,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\OptionsResolver\Options;

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
                        $attributes['class'] .= ' sir';
                    }else{

                        $attributes['class'] = 'sir';

                    }
                }

                return $attributes;

            },
        ));

    }

    /**
     * Pass the select2 attribute to the view
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('select2', $options)) $view->set('select2', $options['select2']);
    }
}