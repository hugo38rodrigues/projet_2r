<?php
namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
        ];
    }

    public function onSetupMenu(KnpMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->addChild('accueil', [
                'route' => 'accueil',
                'label' => 'Accueil',
                'childOptions' => $event->getChildOptions()]
        )->setLabelAttribute('icon', 'fas fa-home');


        $menu->addChild('Statistique', [
            'route' => 'stat_recherche_index',
            'label' => 'Statistique',
            'childOptions' => $event->getChildOptions()
        ])->setExtra('routes', [
            ['route' => 'item1_index'],
            ['route' => 'item1_edit'],
            ['route' => 'item1_show']
        ])->setLabelAttribute('icon', 'fa fa-sign-in');
/*
        $menu->addChild('Item1', [
            #'route' => 'item1_index',
            'label' => 'Item1',
            'childOptions' => $event->getChildOptions()
        ])->setExtra('routes', [
            ['route' => 'item1_index'],
            ['route' => 'item1_edit'],
            ['route' => 'item1_show']
        ])->setLabelAttribute('icon', 'fas fa-list');*/

        //if ($this->security->isGranted('ROLE_GESTION') ||
         //   $this->security->isGranted('ROLE_ADMIN')) {

            $menu->addChild('gestion', [
                    'label' => 'Console de gestion',
                    'childOptions' => $event->getChildOptions()]
            )->setLabelAttribute('icon', 'fas fa-cogs');

            $menu['gestion']->addChild('gestionUser', [
                'route' => 'utilisateur_index',
                'label' => 'Liste des utilisateurs',
                'childOptions' => $event->getChildOptions()
            ])->setExtra('routes', [
                ['route' => 'item1_index'],
                ['route' => 'item1_edit'],
                ['route' => 'item1_show']
            ])->setLabelAttribute('icon', 'fas fa-cogs');

        $menu['gestion']->addChild('gestionRess', [
            'route' => 'ressource_index',
            'label' => 'Liste des ressources',
            'childOptions' => $event->getChildOptions()
        ])->setExtra('routes', [
            ['route' => 'item1_index'],
            ['route' => 'item1_edit'],
            ['route' => 'item1_show']
        ])->setLabelAttribute('icon', 'fas fa-cogs');

            $menu['gestion']->addChild('gestionCategorie', [
                'route' => 'categorie_index',
                'label' => 'Liste des catégories',
                'childOptions' => $event->getChildOptions()
            ])->setExtra('routes', [
                ['route' => 'item2_index'],
                ['route' => 'item2_edit'],
                ['route' => 'item2_show']
            ])->setLabelAttribute('icon', 'fas fa-cogs');

        $menu['gestion']->addChild('gestionEtat', [
            'route' => 'etat_index',
            'label' => 'Liste des Etats',
            'childOptions' => $event->getChildOptions()
        ])->setExtra('routes', [
            ['route' => 'item2_index'],
            ['route' => 'item2_edit'],
            ['route' => 'item2_show']
        ])->setLabelAttribute('icon', 'fas fa-cogs');


        //}
    }
}