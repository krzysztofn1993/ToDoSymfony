<?php

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CredentialsForm extends AbstractType
{
    /**
     * Function for creating form for registering user
     *
     * @param FormBuilderInterface $formBuilderInterface
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $formBuilderInterface, array $options)
    {
        $formBuilderInterface
            ->add('name', TextType::class)
            ->add('password', PasswordType::class)
            ->add('register', SubmitType::class);
    }
}
