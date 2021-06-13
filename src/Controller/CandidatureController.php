<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OffreEmploiRepository;
use App\Entity\OffreEmploi;


/**
 * @Route("candidat/candidature")
 */
class CandidatureController extends AbstractController
{
    /**
     * @Route("/", name="candidature_index", methods={"GET"})
     */
    public function index(CandidatureRepository $candidatureRepository): Response
    {   
        $nbrepost = $this->getUser()->getNbrePos();
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
            'nbrepostulation' => $nbrepost,
        ]);
    }

    /**
     * @Route("/new/{id}", name="candidature_new", methods={"GET","POST"})
     */
    public function new($id, OffreEmploiRepository $offreEmploiRepository, OffreEmploi $offreEmploi, CandidatureRepository $candidatureRepository): Response
    {   
        $date =  new \DateTime();
        $offre = $offreEmploiRepository->find($id);
        $nbrePostul = $this->getUser()->getNbrePos();
        $reglePostul = $this->getUser()->getRegles()->getNbrPostulation();
        $cndture = $candidatureRepository->findByUserOffre($offre, $this->getUser());

        if (count($cndture) == 0 ) {
            if ($nbrePostul <= $reglePostul) {
                $candidature = new Candidature();
                $candidature->setUser($this->getUser());       
                $candidature->setOffreEmploi($offre);
                $candidature->setDateCreation($date);
                $candidature->setEtatCandidature(1);
        
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidature);
                $entityManager->flush();
        
                return $this->render('offre_emploi/show.html.twig', [
                    'offre_emploi' => $offreEmploi,
                    'success' => "La postulation a été effectuée avec succés",
                    'error' => null,
                    'nbrePostul' => count($cndture)+1,
                ]);
            } else {
                return $this->render('offre_emploi/show.html.twig', [
                    'offre_emploi' => $offreEmploi,
                    'success' => null,
                    'error' => "Vous avez atteint le nombre de postulation autorisée",
                    'nbrePostul' => count($cndture),
                ]);
            }
        } else {
                return $this->render('offre_emploi/show.html.twig', [
                    'offre_emploi' => $offreEmploi,
                    'success' => null,
                    'error' => "Vous avez dejà postulé à cet offre",
                    'nbrePostul' => count($cndture),
                ]);
        }
    }

    /**
     * @Route("/{id}", name="candidature_show", methods={"GET"})
     */
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }
}
