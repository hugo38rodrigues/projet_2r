<?php

namespace App\Form;

use App\Entity\Etat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', null, [
                'label' => 'etat.libelle',
                'translation_domain' => 'etat' 
            ])
            ->add('btn_fermer', SubmitType::class, [
                'label' => 'etat.btn_fermer',
                'translation_domain' => 'etat', 
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-default',
                    'data-dismiss' => "modal",
                ]
            ])
            ->add('btn_valider', SubmitType::class, [
                'label' => 'etat.btn_valider',
                'translation_domain' => 'etat', 
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
            'data_class' => Etat::class,
        ]);
    }
}
