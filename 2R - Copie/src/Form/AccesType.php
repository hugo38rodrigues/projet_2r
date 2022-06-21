<?php

namespace App\Form;

use App\Entity\Acces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('niveau', null, [
                'label' => 'acces.niveau',
                'translation_domain' => 'acces' 
            ])
            ->add('btn_fermer', SubmitType::class, [
                'label' => 'acces.btn_fermer',
                'translation_domain' => 'acces', 
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-default',
                    'data-dismiss' => "modal",
                ]
            ])
            ->add('btn_valider', SubmitType::class, [
                'label' => 'acces.btn_valider',
                'translation_domain' => 'acces', 
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-success',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acces::class,
        ]);
    }
}
