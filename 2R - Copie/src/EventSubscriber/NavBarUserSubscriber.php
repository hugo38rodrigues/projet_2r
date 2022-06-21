<?php
namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Controller\SidebarController;
use KevinPapst\AdminLTEBundle\Event\NavbarUserEvent;
use KevinPapst\AdminLTEBundle\Event\ShowUserEvent;
use KevinPapst\AdminLTEBundle\Model\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class NavBarUserSubscriber implements EventSubscriberInterface
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NavbarUserEvent::class => ['onShowUser', 100],
            SidebarController::class => ['onShowUser', 100],
        ];
    }

    public function onShowUser(ShowUserEvent $event)
    {
        if (null === $this->security->getUser()) {
            return;
        }

        $user = new UserModel();
        $user
            ->setId(0)
            ->setName($this->security->getUser()->getNom().' '.$this->security->getUser()->getPreNom().' ('.$this->security->getUser()->getNumeroAgent().')')
            ->setUsername(implode("<br>",$this->security->getUser()->getRoles()))
            ->setAvatar('/bundles/adminlte/images/default_avatar.png')
//            ->setIsOnline(true)
//            ->setTitle('Demo user')
//            ->setMemberSince(new \DateTime())
        ;

        $event->setUser($user);
    }
}
