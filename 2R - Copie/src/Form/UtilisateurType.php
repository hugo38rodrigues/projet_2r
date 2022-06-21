<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('droit', null, [
                'label' => 'utilisateur.droit',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('nom', null, [
                'label' => 'utilisateur.nom',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('prenom', null, [
                'label' => 'utilisateur.prenom',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('dateNaiss', null, [
                'label' => 'utilisateur.dateNaiss',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('actif', null, [
                'label' => 'utilisateur.actif',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('statRecherches', null, [
                'label' => 'utilisateur.statRecherches',
                'translation_domain' => 'utilisateur' 
            ])
            ->add('btn_fermer', SubmitType::class, [
                'label' => 'utilisateur.btn_fermer',
                'translation_domain' => 'utilisateur', 
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-default',
                    'data-dismiss' => "modal",
                ]
            ])
            ->add('btn_valider', SubmitType::class, [
                'label' => 'utilisateur.btn_valider',
                'translation_domain' => 'utilisateur', 
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
            'data_class' => Utilisateur::class,
        ]);
    }
}
