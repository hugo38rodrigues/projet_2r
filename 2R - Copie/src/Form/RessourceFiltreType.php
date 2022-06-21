<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Ressource;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('exploite', null, [
                'label' => 'Exploite',
                'translation_domain' => 'ressource',
                'required' => false
            ])
            ->add('demarre', null, [
                'label' => 'Demarre',
                'translation_domain' => 'ressource',
                'required' => false
            ])

            ->add('categorie', null, [
                'label' => 'Categorie',
                'translation_domain' => 'ressource' ,
                'required' => false

            ])
            ->add('etat', null, [
                'label' => 'Etat',
                'translation_domain' => 'ressource',
                'required' => false
            ])
            ->add('acces', null, [
                'label' => 'Acces',
                'translation_domain' => 'ressource',
                'required' => false
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
