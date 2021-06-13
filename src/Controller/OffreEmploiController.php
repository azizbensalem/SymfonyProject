<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use App\Form\OffreEmploiType;
use App\Repository\OffreEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CandidatureRepository;

class OffreEmploiController extends AbstractController
{
    /**
     * @Route("/candidat/offredemploi/", name="offre_emploi_index", methods={"GET"})
     */
    public function index(OffreEmploiRepository $offreEmploiRepository): Response
    {
        return $this->render('offre_emploi/all.html.twig', [
            'offre_emplois' => $offreEmploiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/recruteur/offredemploi/", name="offre_emploi_byrecuiter", methods={"GET"})
     */
    public function indexOfRecruiter(OffreEmploiRepository $offreEmploiRepository): Response
    {   
        $user = $this->getUser();
        return $this->render('offre_emploi/index.html.twig', [
            'offre_emplois' => $offreEmploiRepository->findByRecruiter($user->getId()),
        ]);
    }

    /**
     * @Route("/recruteur/offredemploi/new", name="offre_emploi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {   
        $offreEmploi = new OffreEmploi();
        $user = $this->getUser();
        $form = $this->createForm(OffreEmploiType::class, $offreEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreEmploi->setIdRecruteur($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offreEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('offre_emploi_byrecuiter');
        }

        return $this->render('offre_emploi/new.html.twig', [
            'offre_emploi' => $offreEmploi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recruteur/offredemploi/{id}", name="offre_emploi_show", methods={"GET"})
     */
    public function showForRecruiter(OffreEmploi $offreEmploi): Response
    {   
        $candidat = $this->getUser();
        if ($offreEmploi->getIdRecruteur()->getId() == $candidat->getId()) {
            return $this->render('offre_emploi/show.html.twig', [
            'offre_emploi' => $offreEmploi,
        ]);
        } else {
            return $this->redirectToRoute('offre_emploi_byrecuiter');
        }
    }

    /**
     * @Route("/candidat/offredemploi/{id}", name="offre_emploi_show", methods={"GET"})
     */
    public function showForCandidate(OffreEmploi $offreEmploi, CandidatureRepository $candidatureRepository): Response
    {       
            $cndture = $candidatureRepository->findByUserOffre($offreEmploi, $this->getUser());
            return $this->render('offre_emploi/show.html.twig', [
            'offre_emploi' => $offreEmploi,
            'error' => null,
            'success' => null,
            'nbrePostul' => count($cndture),
            ]);
    }

    /**
     * @Route("/recruteur/offredemploi/{id}/edit", name="offre_emploi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OffreEmploi $offreEmploi): Response
    {
        $candidat = $this->getUser();
        if ($offreEmploi->getIdRecruteur()->getId() == $candidat->getId()) {
                $form = $this->createForm(OffreEmploiType::class, $offreEmploi);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('offre_emploi_byrecuiter');
                }

                return $this->render('offre_emploi/edit.html.twig', [
                    'offre_emploi' => $offreEmploi,
                    'form' => $form->createView(),
                ]);
        } else {
            return $this->redirectToRoute('offre_emploi_byrecuiter');
        }
    }

    /**
     * @Route("/recruteur/offredemploi/{id}", name="offre_emploi_delete", methods={"POST"})
     */
    public function delete(Request $request, OffreEmploi $offreEmploi): Response
    {
        $candidat = $this->getUser();
        if ($offreEmploi->getIdRecruteur()->getId() == $candidat->getId()) {
                if ($this->isCsrfTokenValid('delete'.$offreEmploi->getId(), $request->request->get('_token'))) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($offreEmploi);
                    $entityManager->flush();
                }

                return $this->redirectToRoute('offre_emploi_byrecuiter');
        } else {
            return $this->redirectToRoute('offre_emploi_byrecuiter');
        }
    }
}
