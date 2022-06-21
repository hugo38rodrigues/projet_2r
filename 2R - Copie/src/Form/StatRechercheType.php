<?php

namespace App\Form;

use App\Entity\StatRecherche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recherche', null, [
                'label' => 'statRecherche.recherche',
                'translation_domain' => 'statRecherche' 
            ])
            ->add('nbrRecherche', null, [
                'label' => 'statRecherche.nbrRecherche',
                'translation_domain' => 'statRecherche' 
            ])
            ->add('utilisateurs', null, [
                'label' => 'statRecherche.utilisateurs',
                'translation_domain' => 'statRecherche' 
            ])
            ->add('btn_fermer', SubmitType::class, [
                'label' => 'statRecherche.btn_fermer',
                'translation_domain' => 'statRecherche', 
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-default',
                    'data-dismiss' => "modal",
                ]
            ])
            ->add('btn_valider', SubmitType::class, [
                'label' => 'statRecherche.btn_valider',
                'translation_domain' => 'statRecherche', 
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
            'data_class' => StatRecherche::class,
        ]);
    }
}
