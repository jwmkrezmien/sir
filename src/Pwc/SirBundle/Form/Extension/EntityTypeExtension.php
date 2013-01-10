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
        //$resolver->setOptional(array('select2'));
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

/*
                echo 'Run<br/>';

                if (empty($attributes))
                {
                    echo 'attr is leeg <br/>';
                }else{
                    echo 'attr is niet leeg <br/>';
                    var_dump($attributes);

                    if (empty($attributes['class']))
                    {
                        echo 'attr["class"] is leeg <br/>';
                    }else{
                        echo 'attr["class"] is niet leeg <br/>';
                        var_dump($attributes['class']);
                    }
                }
*/
                var_dump($attributes);

                if ($options['select2'])
                {

                    echo 'option select2 is set <br/>';
    /*
                    return function (array $array) {

                        if (array_key_exists('class', $array)) $array['class'] .= ' alter-select2';

                        return $array;
                    };
*/
                }


/*
                    if (array_key_exists('class', $options))
                    {
                        $previousValue['class'] = function ($value) { return $value . ' alter-select2'; };
                        return $previousValue;
                    }else
                    {
                        $previousValue['class'] = 'alter-select2';
                        return $previousValue;
                    }

                    return $previousValue;
                }
 */               return array();
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
            /*
                        if (!isset($options['attr']['class']))
                        {
                            $options['attr']['class'] = 'select2';

                        }else{

                            $options['attr']['class'] .= 'select2';

                        }

                        var_dump($options);
            /*
                        $parentData = $form->getParent()->getData();

                        if (null !== $parentData) {
                            $propertyPath = new PropertyPath($options['image_path']);
                            $imageUrl = $propertyPath->getValue($parentData);
                        } else {
                            $imageUrl = null;
                        }

                        // set an "image_url" variable that will be available when rendering this field
                        $view->set('image_url', $imageUrl);
            */
        }
    }

/*
    /**
     * set the attribute class
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr'        => array('class' => "alter-select sir"),
            'empty_value' => ''
        ));
    }
*/
}