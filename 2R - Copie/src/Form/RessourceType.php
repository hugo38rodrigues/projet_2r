<?php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'Titre',
                'translation_domain' => 'ressource' ,
                'required'=>true
            ])
            ->add('resume', null, [
                'label' => 'Resume',
                'translation_domain' => 'ressource' ,
                'required'=>true,
                'attr' => [
                    'style' => 'width:100%;margin-bottom:10%',
                ],
            ])
            ->add('dateCrea', null, [
                'label' => 'ressource.dateCrea',
                'translation_domain' => 'ressource'
            ])
            ->add('valide', null, [
                'label' => 'ressource.valide',
                'translation_domain' => 'ressource'
            ])
            ->add('exploite', null, [
                'label' => 'ressource.exploite',
                'translation_domain' => 'ressource'
            ])
            ->add('demarre', null, [
                'label' => 'ressource.demarre',
                'translation_domain' => 'ressource'
            ])
            ->add('Createur', null, [
                'label' => 'ressource.Createur',
                'translation_domain' => 'ressource'
            ])
            ->add('categorie', null, [
                'label' => 'Categorie',
                'translation_domain' => 'ressource' ,
                'required'=>true
            ])
            ->add('etat', null, [
                'label' => 'ressource.etat',
                'translation_domain' => 'ressource'
            ])
            ->add('acces', null, [
                'label' => 'ressource.acces',
                'translation_domain' => 'ressource'
            ])
            ->add('btn_fermer', SubmitType::class, [
                'label' => 'ressource.btn_fermer',
                'translation_domain' => 'ressource', 
                'label_html' => true,
                'attr' => [
                    'class' => 'btn btn-default',
                    'data-dismiss' => "modal",
                ]
            ])
            ->add('btn_valider', SubmitType::class, [
                'label' => 'ressource.btn_valider',
                'translation_domain' => 'ressource', 
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
            'data_class' => Ressource::class,
        ]);
    }
}
