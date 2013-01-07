<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('tools', 'genemu_jqueryselect2_entity', array(
                'class' => 'Pwc\SirBundle\Entity\Tool',
                'property' => 'name',
                'multiple' => true
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwc\SirBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'pwc_sirbundle_producttype';
    }
}
