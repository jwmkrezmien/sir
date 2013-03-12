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
            ->add('name', null, array('label' => 'form.label.vulndescription.name'))
            ->add('description', null, array('label' => 'form.label.vulndescription.description'))
            ->add('risk', null, array('label' => 'form.label.vulndescription.risk'))
            ->add('solution', null, array('label' => 'form.label.vulndescription.solution'))
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
