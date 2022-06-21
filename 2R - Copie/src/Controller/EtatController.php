<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatType;
use App\Repository\EtatRepository;
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
 * @Route("/etat")
 */
class EtatController extends AbstractController
{

    /** @var EtatRepository */
    private $etatRepository;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(EtatRepository $etatRepository, 
                                EntityManagerInterface $entityManager, 
                                TranslatorInterface $translator) 
    {
        $this->etatRepository = $etatRepository;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="etat_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $etat = new Etat();
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($etat);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('etat.new.error',[],'etat'));
                return $this->redirectToRoute('etat_index');
            }
            $this->addFlash('success', $this->translator->trans('etat.new.success',[],'etat'));
            return $this->redirectToRoute('etat_index');
        }

        return $this->render('etat/index.html.twig', [
            'etats' => $this->etatRepository->findAll(),
            'modal' => [
                'etat' => $etat,
                'form'  => $form->createView(),
                'title' => $this->translator->trans('etat.new.boxtitle', [], 'etat'),
                'requiredFields' => true,
            ]
        ]);
    }

    /**
     * @Route("/delete-etat", name="delete_etat", methods={"POST"})
     */
    public function delete(Request $request, EtatRepository $etatRepository)
    {
        $etat = $etatRepository->find(
            $request->get('delete_form_etat')['id']
        );

        try {
            $this->entityManager->remove($etat);
            $this->entityManager->flush();
        }
        catch (\Throwable $th) {
            $this->addFlash('error', $this->translator->trans('etat.delete.error',[],'etat'));
            return $this->redirectToRoute('etat_index');
        }

        $this->addFlash('success', $this->translator->trans('etat.delete.success',[],'etat'));
        return $this->redirectToRoute('etat_index');
    }

    /**
     * @Route("/{id}", name="etat_show", methods={"GET","POST"})
     */
    public function show(Request $request, Etat $etat): Response
    {
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($etat);
                $this->entityManager->flush();
            } catch (\Throwable $th) {
                $this->addFlash('error', $this->translator->trans('etat.edit.error',[],'etat'));
                return $this->redirectToRoute('etat_index');
            }
            $this->addFlash('success', $this->translator->trans('etat.edit.success',[],'etat'));
            return $this->redirectToRoute('etat_show',['id' => $etat->getId()]);
        }

        return $this->render('etat/show.html.twig', [
            'etat' => $etat,
            'modalEdit' => [
                'etat' => $etat,
                'form' => $form->createView(),
                'title' => $this->translator->trans('etat.edit.boxtitle', [], 'etat'),
                'requiredFields' => true,
            ],
        ]);
    }
}
