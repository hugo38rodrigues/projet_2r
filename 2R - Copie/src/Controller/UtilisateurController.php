<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\loginType;
use App\Form\SigninType;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Cnam\TwigBootstrapBundle\Table\DataTableQuery;
use Cnam\TwigBootstrapBundle\Table\DataTableResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{

    /** @var UtilisateurRepository */
    private $utilisateurRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(UtilisateurRepository $utilisateurRepository, 
                                EntityManagerInterface $entityManager, 
                                TranslatorInterface $translator) 
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="utilisateur_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($utilisateur);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('utilisateur.new.error',[],'utilisateur'));
                return $this->redirectToRoute('utilisateur_index');
            }
            $this->addFlash('success', $this->translator->trans('utilisateur.new.success',[],'utilisateur'));
            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $this->utilisateurRepository->findAll(),
            'modal' => [
                'utilisateur' => $utilisateur,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('utilisateur.new.boxtitle', [], 'utilisateur'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/deco", name="utilisateur_deco", methods={"GET","POST"})
     */
    public function deco(Request $request): Response
    {
        $_SESSION["profil"] =null;
        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/login", name="utilisateur_login", methods={"GET","POST"})
     */
    public function login(Request $request): Response
    {
        $formSearch = $this->createFormBuilder()
            ->add('search', TextType::class, array(
                'label' => false,
                'attr'  => array('placeholder' => 'Search'),
                'mapped' => false
            ))
            ->getForm();

        $formSearch->handleRequest($request);

        $utilisateur = new Utilisateur();
        $form = $this->createForm(loginType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $verif = $this->utilisateurRepository->findOneBy(array('login'=> $utilisateur->getLogin() ,'password'=> $utilisateur->getPassword()  ));

                if ($verif == null){
                    return $this->redirectToRoute('utilisateur_login');
                }else{


                    $_SESSION["profil"] =$verif;

                    return $this->redirectToRoute('accueil');
                }

        }

        if (isset($_SESSION["profil"]))
        {
            $userCo=$_SESSION["profil"];
        }
        else{
            $userCo=null;
        }

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            return $this->redirectToRoute('accueil');
        }


        return $this->render('utilisateur/login.html.twig', [
            'search'=> $formSearch->createView(),
            'userCo'=>$userCo,
            'utilisateurs' => $this->utilisateurRepository->findAll(),
            'modal' => [
                'utilisateur' => $utilisateur,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('utilisateur.new.boxtitle', [], 'utilisateur'),
                'requiredFields' => true,
            ]
        ]);
    }


    /**
     * @Route("/signin", name="utilisateur_signin", methods={"GET","POST"})
     */
    public function signin(Request $request): Response
    {
        $formSearch = $this->createFormBuilder()
            ->add('search', TextType::class, array(
                'label' => false,
                'attr'  => array('placeholder' => 'Search'),
                'mapped' => false
            ))
            ->getForm();

        $formSearch->handleRequest($request);

        $utilisateur = new Utilisateur();
        $form = $this->createForm(SigninType::class, $utilisateur);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

                $this->entityManager->persist($utilisateur);
                $this->entityManager->flush();
                $_SESSION["profil"] =$utilisateur;

           return $this->redirectToRoute('accueil');

        }



        if (isset($_SESSION["profil"]))
        {
            $userCo=$_SESSION["profil"];
        }
        else{
            $userCo=null;
        }

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $sql = "SELECT * FROM public.ressource p where p.titre like '%" . $formSearch->get('search')->getData() . "%' ";
            $em = $this->entityManager;
            $statementProc = $em->getConnection()->prepare($sql);
            $resultsProc = $statementProc->executeQuery()->fetchAllAssociative();

            return $this->render('ressource/accueil.html.twig', [
                'search'=> $formSearch->createView(),
                'userCo'=>$userCo,
                'ressources' => $this->ressourceRepository->search($resultsProc),
                'formCreate'=>$form->createView(),
            ]);
        }

        return $this->render('utilisateur/signin.html.twig', [
            'search'=> $formSearch->createView(),
            'userCo'=>$userCo,
            'utilisateurs' => $this->utilisateurRepository->findAll(),
            'modal' => [
                'utilisateur' => $utilisateur,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('utilisateur.new.boxtitle', [], 'utilisateur'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/delete-utilisateur", name="delete_utilisateur", methods={"POST"})
     */
    public function delete(Request $request, UtilisateurRepository $utilisateurRepository)
    {
        $utilisateur = $utilisateurRepository->find(
            $request->get('delete_form_utilisateur')['id']
        );

        try {
            $this->entityManager->remove($utilisateur);
            $this->entityManager->flush();
        }
        catch (\Throwable $th) {
            $this->addFlash('error', $this->translator->trans('utilisateur.delete.error',[],'utilisateur'));
            return $this->redirectToRoute('utilisateur_index');
        }

        $this->addFlash('success', $this->translator->trans('utilisateur.delete.success',[],'utilisateur'));
        return $this->redirectToRoute('utilisateur_index');
    }



    /**
     * @Route("/{id}", name="utilisateur_show", methods={"GET","POST"})
     */
    public function show(Request $request, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($utilisateur);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('utilisateur.edit.error',[],'utilisateur'));
                return $this->redirectToRoute('utilisateur_index');
            }
            $this->addFlash('success', $this->translator->trans('utilisateur.edit.success',[],'utilisateur'));
            return $this->redirectToRoute('utilisateur_show',['id' => $utilisateur->getId()]);
        }

        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
            'modalEdit' => [
                'utilisateur' => $utilisateur,
                'form' => $form->createView(),
                'title' => $this->translator->trans('utilisateur.edit.boxtitle', [], 'utilisateur'),
                'requiredFields' => true,
            ],
        ]);
    }
}
