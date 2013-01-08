<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VulnDescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'vulndescription.form.name', 'attr' => array("class" => "sir")))
            ->add('description', null, array('label' => 'vulndescription.form.description', 'attr' => array("class" => "sir")))
            ->add('risk', null, array('label' => 'vulndescription.form.risk', 'attr' => array("class" => "sir")))
            ->add('solution', null, array('label' => 'vulndescription.form.solution', 'attr' => array("class" => "sir")))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwc\SirBundle\Entity\VulnDescription'
        ));
    }

    public function getName()
    {
        return 'pwc_sirbundle_vulndescriptiontype';
    }
}
