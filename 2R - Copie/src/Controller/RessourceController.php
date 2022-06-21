<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Cnam\TwigBootstrapBundle\Table\DataTableQuery;
use Cnam\TwigBootstrapBundle\Table\DataTableResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ressource")
 */
class RessourceController extends AbstractController
{

    /** @var RessourceRepository */
    private $ressourceRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(RessourceRepository $ressourceRepository,
                                EntityManagerInterface $entityManager,
                                TranslatorInterface $translator)
    {
        $this->ressourceRepository = $ressourceRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }




    /**
     * @Route("/statConsultation", name="statConsultation", methods={"GET","POST"})
     */
    public function statConsultation(Request $request): Response
    {
        return $this->render('ressource/StatConsult.html.twig', [
            'ressources' => $this->ressourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/easterEgg", name="easterEgg")
     */
    public function easterEgg()
    {
        return $this->render('ressource/EasterEgg.html.twig', [
        ]);
    }

    /**
     * @Route("/statCreaExploit", name="statCreaExploit", methods={"GET","POST"})
     */
    public function statCreaExploit(Request $request): Response
    {
        return $this->render('ressource/StatCreaExploit.html.twig', [
            'ressources' => $this->ressourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="ressource_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($ressource);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('ressource.new.error',[],'ressource'));
                return $this->redirectToRoute('ressource_index');
            }
            $this->addFlash('success', $this->translator->trans('ressource.new.success',[],'ressource'));
            return $this->redirectToRoute('ressource_index');
        }

        return $this->render('ressource/index.html.twig', [
            'ressources' => $this->ressourceRepository->findAll(),
            'modal' => [
                'ressource' => $ressource,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('ressource.new.boxtitle', [], 'ressource'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/delete-ressource", name="delete_ressource", methods={"POST"})
     */
    public function delete(Request $request, RessourceRepository $ressourceRepository)
    {
        $ressource = $ressourceRepository->find(
            $request->get('delete_form_ressource')['id']
        );

        try {
            $this->entityManager->remove($ressource);
            $this->entityManager->flush();
        }
        catch (\Throwable $th) {
            $this->addFlash('error', $this->translator->trans('ressource.delete.error',[],'ressource'));
            return $this->redirectToRoute('ressource_index');
        }

        $this->addFlash('success', $this->translator->trans('ressource.delete.success',[],'ressource'));
        return $this->redirectToRoute('ressource_index');
    }

    /**
     * @Route("/{id}", name="ressource_show", methods={"GET","POST"})
     */
    public function show(Request $request, Ressource $ressource): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($ressource);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('ressource.edit.error',[],'ressource'));
                return $this->redirectToRoute('ressource_index');
            }
            $this->addFlash('success', $this->translator->trans('ressource.edit.success',[],'ressource'));
            return $this->redirectToRoute('ressource_show',['id' => $ressource->getId()]);
        }

        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
            'modalEdit' => [
                'ressource' => $ressource,
                'form' => $form->createView(),
                'title' => $this->translator->trans('ressource.edit.boxtitle', [], 'ressource'),
                'requiredFields' => true,
            ],
        ]);
    }
}
