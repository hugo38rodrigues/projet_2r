<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SigninType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('prenom', null, [
                'label' => 'Prenom',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('dateNaiss', BirthdayType::class, [
                'label' => 'date de naissance',
                'translation_domain' => 'utilisateur'
            ])
            ->add('login', null, [
                'label' => 'login',
                'translation_domain' => 'utilisateur'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'password',
                'translation_domain' => 'utilisateur'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
