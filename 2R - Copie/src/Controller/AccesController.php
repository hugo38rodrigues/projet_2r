<?php

namespace App\Controller;

use App\Entity\Acces;
use App\Form\AccesType;
use App\Repository\AccesRepository;
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
 * @Route("/acces")
 */
class AccesController extends AbstractController
{

    /** @var AccesRepository */
    private $accesRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(AccesRepository $accesRepository, 
                                EntityManagerInterface $entityManager, 
                                TranslatorInterface $translator) 
    {
        $this->accesRepository = $accesRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="acces_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $acces = new Acces();
        $form = $this->createForm(AccesType::class, $acces);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($acces);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('acces.new.error',[],'acces'));
                return $this->redirectToRoute('acces_index');
            }
            $this->addFlash('success', $this->translator->trans('acces.new.success',[],'acces'));
            return $this->redirectToRoute('acces_index');
        }

        return $this->render('acces/index.html.twig', [
            'access' => $this->accesRepository->findAll(),
            'modal' => [
                'acces' => $acces,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('acces.new.boxtitle', [], 'acces'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/delete-acces", name="delete_acces", methods={"POST"})
     */
    public function delete(Request $request, AccesRepository $accesRepository)
    {
        $acces = $accesRepository->find(
            $request->get('delete_form_acces')['id']
        );

        try {
            $this->entityManager->remove($acces);
            $this->entityManager->flush();
        }
        catch (\Throwable $th) {
            $this->addFlash('error', $this->translator->trans('acces.delete.error',[],'acces'));
            return $this->redirectToRoute('acces_index');
        }

        $this->addFlash('success', $this->translator->trans('acces.delete.success',[],'acces'));
        return $this->redirectToRoute('acces_index');
    }

    /**
     * @Route("/{id}", name="acces_show", methods={"GET","POST"})
     */
    public function show(Request $request, Acces $acces): Response
    {
        $form = $this->createForm(AccesType::class, $acces);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($acces);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('acces.edit.error',[],'acces'));
                return $this->redirectToRoute('acces_index');
            }
            $this->addFlash('success', $this->translator->trans('acces.edit.success',[],'acces'));
            return $this->redirectToRoute('acces_show',['id' => $acces->getId()]);
        }

        return $this->render('acces/show.html.twig', [
            'acces' => $acces,
            'modalEdit' => [
                'acces' => $acces,
                'form' => $form->createView(),
                'title' => $this->translator->trans('acces.edit.boxtitle', [], 'acces'),
                'requiredFields' => true,
            ],
        ]);
    }
}
