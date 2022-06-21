<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Invitation;
use App\Entity\Lien;
use App\Entity\Message;
use App\Entity\Ressource;
use App\Entity\StatRecherche;
use App\Form\CommentaireType;
use App\Form\InvitType;
use App\Form\MessageType;
use App\Form\RessourceCreaType;
use App\Form\RessourceFiltreType;
use App\Form\SearchType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RessourceRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\StatRechercheRepository;

class AccueilController extends AbstractController
{

    /** @var StatRechercheRepository */
    private $statRechercheRepository;
    /** @var UtilisateurRepository */
    private $utilisateurRepository;
    /** @var RessourceRepository */
    private $ressourceRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(StatRechercheRepository $statRechercheRepository,
                                UtilisateurRepository $utilisateurRepository,
                                RessourceRepository $ressourceRepository,
                                EntityManagerInterface $entityManager,
                                TranslatorInterface $translator)
    {
        $this->statRechercheRepository = $statRechercheRepository;
        $this->ressourceRepository = $ressourceRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
        $this->utilisateurRepository = $utilisateurRepository;
    }

    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceCreaType::class, $ressource);
        $form->handleRequest($request);
        $formComm = $this->createForm(CommentaireType::class);

        if (isset($_SESSION["profil"]))
        {
            $userCo=$this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId()));
        }
        else{
            $userCo=null;
        }

        $formSearch = $this->createFormBuilder()
            ->add('search', TextType::class, array(
                'label' => false,
                'attr'  => array('placeholder' => 'Search'),
                'mapped' => false
            ))
            ->getForm();



        $formFiltre = $this->createForm(RessourceFiltreType::class);
        $formFiltre->handleRequest($request);

        if ( ($formFiltre->isSubmitted() && $formFiltre->isValid()) ) {

            $filtres = $formFiltre->getData();


            return $this->render('ressource/accueil.html.twig', [
                'search'=> $formSearch->createView(),
                'userCo'=>$userCo,
                'ressources' => $this->ressourceRepository->findByFiltre($filtres),
                'formFiltre' => $formFiltre->createView(),
                'formCreate'=>$form->createView(),

            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {

                if ($_SESSION["profil"]==null)
                {
                    return $this->redirectToRoute('accueil');
                }
                else{
                    $ressource->setCreateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                    $this->entityManager->persist($ressource);
                    $lien = new Lien();
                    $lien->setRessource($ressource);
                    $lien->setType('participe');
                    $lien->setUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                    $this->entityManager->persist($lien);
                    $this->entityManager->flush();
                }

           return $this->redirectToRoute('accueil');
        }

        $formSearch->handleRequest($request);
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $statRecherche = $this->statRechercheRepository->findOneBy( array('recherche' => $formSearch->get('search')->getData()));

            if ($statRecherche == null){
                $stat= new StatRecherche();
                $stat->setNbrRecherche(1);
                $stat->setRecherche($formSearch->get('search')->getData());
                if (isset($_SESSION["profil"]))
                {
                    $stat->addUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                }
                $this->entityManager->persist($stat);
                $this->entityManager->flush();
            }else{
                $statRecherche->setNbrRecherche($statRecherche->getNbrRecherche()+1);
                if ($_SESSION["profil"]!= null)
                {
                    $statRecherche->addUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                }
                $this->entityManager->persist($statRecherche);
                $this->entityManager->flush();
            }

            $sql = "SELECT * FROM public.ressource p where p.titre like '%" .$formSearch->get('search')->getData() . "%' ";
            $em = $this->entityManager;
            $statementProc = $em->getConnection()->prepare($sql);
            $resultsProc = $statementProc->executeQuery()->fetchAllAssociative();

            return $this->render('ressource/accueil.html.twig', [
                'search'=> $formSearch->createView(),
                'userCo'=>$userCo,
                'formFiltre' => $formFiltre->createView(),
                'ressources' => $this->ressourceRepository->search($resultsProc),
                'formCreate'=>$form->createView(),
            ]);
        }

     //   dump($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId()))->getRessourceLiee());exit();
        return $this->render('ressource/accueil.html.twig', [
            'search'=> $formSearch->createView(),
            'formFiltre' => $formFiltre->createView(),
            'userCo'=>$userCo,
            'ressources' => $this->ressourceRepository->findBy(array(),array('dateCrea'=>'desc')),
            'formCreate'=>$form->createView(),

        ]);
    }

    /**
     * @Route("/DeleteRessource/{id}", name="DeleteRessource", methods={"GET","POST"})
     */
    public function DeleteRessource(Request $request, Ressource $ressource): Response
    {
        if ($_SESSION["profil"] == $ressource->getCreateur())
        {
            $this->entityManager->remove($ressource);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/DeleteFav/{id}", name="DeleteFav", methods={"GET","POST"})
     */
    public function DeleteFav(Request $request, Lien $lien): Response
    {
            $this->entityManager->remove($lien);
            $this->entityManager->flush();

        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/DeletePart/{id}", name="DeletePart", methods={"GET","POST"})
     */
    public function DeletePart(Request $request, Lien $lien): Response
    {
        $this->entityManager->remove($lien);
        $this->entityManager->flush();

        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/DeleteComm/{id}", name="DeleteComm", methods={"GET","POST"})
     */
    public function DeleteComm(Request $request, Commentaire $comm): Response
    {
        $res = $comm->getRessource();
        try {


        if ($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())) == $comm->getUtilisateur() || $_SESSION["profil"]->getDroit()!='CitoyenConnecte')
        {
            $this->entityManager->remove($comm);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('oneRessource',array('id' =>$res->getId()));
        }catch (\Throwable $th) {
            return $this->redirectToRoute('oneRessource',array('id' =>$res->getId()));
        }
    }

    /**
     * @Route("/exploiter/{id}", name="exploiter", methods={"GET","POST"})
     */
    public function exploiter(Request $request, Ressource $ressource): Response
    {
        $ressource->setExploite(true);
        $this->entityManager->persist($ressource);
        $this->entityManager->flush();
        return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
    }

    /**
     * @Route("/demarre/{id}", name="demarre", methods={"GET","POST"})
     */
    public function demarre(Request $request, Ressource $ressource): Response
    {
        if ($ressource->getCategorie()->getLibelle()=='Activité')
        $ressource->setDemarre(true);
        $this->entityManager->persist($ressource);
        $this->entityManager->flush();
        return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
    }

    /**
     * @Route("/exploiterNo/{id}", name="exploiterNo", methods={"GET","POST"})
     */
    public function exploiterNo(Request $request, Ressource $ressource): Response
    {
        $ressource->setExploite(false);
        $this->entityManager->persist($ressource);
        $this->entityManager->flush();
        return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
    }


    /**
     * @Route("/AccepteInvit/{id}", name="AccepteInvit", methods={"GET","POST"})
     */
    public function AccepteInvit(Request $request, Invitation $invite): Response
    {
        try {
        $lien = new Lien();
        $lien->setRessource($invite->getRessource());
        $lien->setUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
        $lien->setType('participe');
        $lien->getUtilisateur()->addRessourceLiee($lien);
        $this->entityManager->persist($lien);
        $res = $invite->getRessource();
        $this->entityManager->remove($invite);
        $this->entityManager->flush();
        return $this->redirectToRoute('oneRessource',array('id' =>$res->getId()));
        }catch (\Throwable $th) {
            return $this->redirectToRoute('oneRessource',array('id' =>$invite->getRessource()->getId()));
        }
    }

    /**
     * @Route("/RefusInvit/{id}", name="RefusInvit", methods={"GET","POST"})
     */
    public function RefusInvit(Request $request, Invitation $invite): Response
    {
        try {
        $res = $invite->getRessource();
        $this->entityManager->remove($invite);
        $this->entityManager->flush();
        return $this->redirectToRoute('oneRessource',array('id' =>$res->getId()));
        }catch (\Throwable $th) {
            return $this->redirectToRoute('oneRessource',array('id' =>$invite->getRessource()->getId()));
        }
    }


    /**
     * @Route("/FavRessource/{id}", name="FavRessource", methods={"GET","POST"})
     */
    public function FavRessource(Request $request, Ressource $ressource): Response
    {
        try {
            $lien = new Lien();
            $lien->setRessource($ressource);
            $lien->setUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
            $lien->setType('favoris');
            $lien->getUtilisateur()->addRessourceLiee($lien);
            $this->entityManager->persist($lien);
            $this->entityManager->flush();

        }catch (\Throwable $th) {
            return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
        }

        return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
    }

    /**
     * @Route("/OneRessource/{id}", name="oneRessource", methods={"GET","POST"})
     */
    public function OneRessource(Request $request, Ressource $ressource): Response
    {
        $ressource->setNbrConsultation($ressource->getNbrConsultation()+1);
        $this->entityManager->persist($ressource);
        $this->entityManager->flush();

        $form = $this->createForm(RessourceCreaType::class, $ressource);
        $form->handleRequest($request);

        $formInvit = $this->createForm(InvitType::class);
        $formInvit->handleRequest($request);

        $formComm = $this->createForm(CommentaireType::class);
        $formComm->handleRequest($request);

        $formChat = $this->createForm(MessageType::class);
        $formChat->handleRequest($request);

        if ($formInvit->isSubmitted() && $formInvit->isValid()) {


            $invites = $formInvit->getData();

            foreach ($invites as $collectionDeMerde){
                foreach ($collectionDeMerde as $invite){
                    $invitation = new Invitation();
                    $invitation->setRessource($ressource);
                    $invitation->setInvite($invite);
                    $invitation->setInviteur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                    $this->entityManager->persist($invitation);
                }
            }
            $this->entityManager->flush();
        }

        if ($formComm->isSubmitted() && $formComm->isValid()) {

            if ($_SESSION["profil"]==null)
            {
                return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
            }
            else{
                $Comm = new Commentaire();
                $Comm->setRessource($ressource);
                $Comm->setUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                $Comm->setText($formComm->getData()->getText());
                $this->entityManager->persist($Comm);
                $this->entityManager->flush();
            }
        }

        if ($formChat->isSubmitted() && $formChat->isValid()) {

            if ($_SESSION["profil"]==null)
            {
                return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
            }
            else{
                $Chat = new Message();
                $Chat->setRessource($ressource);
                $Chat->setUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                $Chat->setText($formChat->getData()->getText());
                $this->entityManager->persist($Chat);
                $this->entityManager->flush();
            }
        }

        $formSearch = $this->createFormBuilder()
            ->add('search', TextType::class, array(
                'label' => false,
                'attr'  => array('placeholder' => 'Search'),
                'mapped' => false
            ))
            ->getForm();

        $formSearch->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($ressource);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
            }
            return $this->redirectToRoute('oneRessource',array('id' =>$ressource->getId()));
        }

        if (isset($_SESSION["profil"]))
        {
            $userCo=$this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId()));
        }
        else{
            $userCo=null;
        }

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $statRecherche = $this->statRechercheRepository->findOneBy( array('recherche' => $formSearch->get('search')->getData()));

            if ($statRecherche == null){
                $stat= new StatRecherche();
                $stat->setNbrRecherche(1);
                $stat->setRecherche($formSearch->get('search')->getData());
                if ($_SESSION["profil"]!= null)
                {
                    $stat->addUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                }
                $this->entityManager->persist($stat);
                $this->entityManager->flush();
            }else{
                $statRecherche->setNbrRecherche($statRecherche->getNbrRecherche()+1);
                if ($_SESSION["profil"]!= null)
                {
                    $statRecherche->addUtilisateur($this->utilisateurRepository->findOneBy(array('id'=>$_SESSION["profil"]->getId())));
                }
                $this->entityManager->persist($statRecherche);
                $this->entityManager->flush();
            }

            $sql = "SELECT * FROM public.ressource p where p.titre like '%" . $formSearch->get('search')->getData() . "%' ";
            $em = $this->entityManager;
            $statementProc = $em->getConnection()->prepare($sql);
            $resultsProc = $statementProc->executeQuery()->fetchAllAssociative();

            return $this->render('ressource/OneRessource.html.twig', [
                'search'=> $formSearch->createView(),
                'formComm'=>$formComm->createView(),
                'formChat'=>$formChat->createView(),
                'formInvit'=>$formInvit->createView(),
                'userCo'=>$userCo,
                'ressources' => $this->ressourceRepository->search($resultsProc),
                'formCreate'=>$form->createView(),
            ]);
        }

        return $this->render('ressource/OneRessource.html.twig', [
            'search'=> $formSearch->createView(),
            'formComm'=>$formComm->createView(),
            'formChat'=>$formChat->createView(),
            'formInvit'=>$formInvit->createView(),
            'userCo'=>$userCo,
            'ressource' => $ressource,
            'formCreate'=>$form->createView(),

        ]);
    }
}
