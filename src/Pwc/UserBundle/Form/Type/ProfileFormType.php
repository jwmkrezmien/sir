<?php

namespace Pwc\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'PwcUserBundle'));

        $builder->add('firstname', null, array(
            'label'              => 'form.firstname',
            'translation_domain' => 'PwcUserBundle'
        ));

        $builder->add('lastname', null, array(
            'label'              => 'form.lastname',
            'translation_domain' => 'PwcUserBundle'
        ));

        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'PwcUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
    }

    public function getName()
    {
        return 'pwc_user_profile';
    }
}
