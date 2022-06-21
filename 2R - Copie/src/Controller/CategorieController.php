<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
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
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{

    /** @var CategorieRepository */
    private $categorieRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(CategorieRepository $categorieRepository, 
                                EntityManagerInterface $entityManager, 
                                TranslatorInterface $translator) 
    {
        $this->categorieRepository = $categorieRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="categorie_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($categorie);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('categorie.new.error',[],'categorie'));
                return $this->redirectToRoute('categorie_index');
            }
            $this->addFlash('success', $this->translator->trans('categorie.new.success',[],'categorie'));
            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/index.html.twig', [
            'categories' => $this->categorieRepository->findAll(),
            'modal' => [
                'categorie' => $categorie,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('categorie.new.boxtitle', [], 'categorie'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/delete-categorie", name="delete_categorie", methods={"POST"})
     */
    public function delete(Request $request, CategorieRepository $categorieRepository)
    {
        $categorie = $categorieRepository->find(
            $request->get('delete_form_categorie')['id']
        );

        try {
            $this->entityManager->remove($categorie);
            $this->entityManager->flush();
        }
        catch (\Throwable $th) {
            $this->addFlash('error', $this->translator->trans('categorie.delete.error',[],'categorie'));
            return $this->redirectToRoute('categorie_index');
        }

        $this->addFlash('success', $this->translator->trans('categorie.delete.success',[],'categorie'));
        return $this->redirectToRoute('categorie_index');
    }

    /**
     * @Route("/{id}", name="categorie_show", methods={"GET","POST"})
     */
    public function show(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($categorie);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('categorie.edit.error',[],'categorie'));
                return $this->redirectToRoute('categorie_index');
            }
            $this->addFlash('success', $this->translator->trans('categorie.edit.success',[],'categorie'));
            return $this->redirectToRoute('categorie_show',['id' => $categorie->getId()]);
        }

        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'modalEdit' => [
                'categorie' => $categorie,
                'form' => $form->createView(),
                'title' => $this->translator->trans('categorie.edit.boxtitle', [], 'categorie'),
                'requiredFields' => true,
            ],
        ]);
    }
}
