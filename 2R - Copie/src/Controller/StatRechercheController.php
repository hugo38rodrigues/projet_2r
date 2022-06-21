<?php

namespace App\Controller;

use App\Entity\StatRecherche;
use App\Form\StatRechercheType;
use App\Repository\StatRechercheRepository;
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
 * @Route("/stat/recherche")
 */
class StatRechercheController extends AbstractController
{

    /** @var StatRechercheRepository */
    private $statRechercheRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(StatRechercheRepository $statRechercheRepository,
                                EntityManagerInterface $entityManager, 
                                TranslatorInterface $translator) 
    {
        $this->statRechercheRepository = $statRechercheRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="stat_recherche_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $statRecherche = new StatRecherche();
        $form = $this->createForm(StatRechercheType::class, $statRecherche);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($statRecherche);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('statRecherche.new.error',[],'statRecherche'));
                return $this->redirectToRoute('stat_recherche_index');
            }
            $this->addFlash('success', $this->translator->trans('statRecherche.new.success',[],'statRecherche'));
            return $this->redirectToRoute('stat_recherche_index');
        }

        return $this->render('stat_recherche/index.html.twig', [
            'stat_recherches' => $this->statRechercheRepository->findAll(),
            'modal' => [
                'statRecherche' => $statRecherche,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('statRecherche.new.boxtitle', [], 'statRecherche'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/delete-stat_recherche", name="delete_stat_recherche", methods={"POST"})
     */
    public function delete(Request $request, StatRechercheRepository $statRechercheRepository)
    {
        $statRecherche = $statRechercheRepository->find(
            $request->get('delete_form_statRecherche')['id']
        );

        try {
            $this->entityManager->remove($statRecherche);
            $this->entityManager->flush();
        }
        catch (\Throwable $th) {
            $this->addFlash('error', $this->translator->trans('statRecherche.delete.error',[],'statRecherche'));
            return $this->redirectToRoute('stat_recherche_index');
        }

        $this->addFlash('success', $this->translator->trans('statRecherche.delete.success',[],'statRecherche'));
        return $this->redirectToRoute('stat_recherche_index');
    }

    /**
     * @Route("/{id}", name="stat_recherche_show", methods={"GET","POST"})
     */
    public function show(Request $request, StatRecherche $statRecherche): Response
    {
        $form = $this->createForm(StatRechercheType::class, $statRecherche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($statRecherche);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('statRecherche.edit.error',[],'statRecherche'));
                return $this->redirectToRoute('stat_recherche_index');
            }
            $this->addFlash('success', $this->translator->trans('statRecherche.edit.success',[],'statRecherche'));
            return $this->redirectToRoute('stat_recherche_show',['id' => $statRecherche->getId()]);
        }

        return $this->render('stat_recherche/show.html.twig', [
            'stat_recherche' => $statRecherche,
            'modalEdit' => [
                'statRecherche' => $statRecherche,
                'form' => $form->createView(),
                'title' => $this->translator->trans('statRecherche.edit.boxtitle', [], 'statRecherche'),
                'requiredFields' => true,
            ],
        ]);
    }
}
