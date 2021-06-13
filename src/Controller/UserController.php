<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/candidat/profil")
*/
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_show", methods={"GET"})
     */
    public function show(): Response
    {   
        $user = $this->getUser();
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {   
            $candidat = $this->getUser();
            if ($user->getId() == $candidat->getId()) {
                $form = $this->createForm(UserType::class, $candidat);
                $form->handleRequest($request);
        
                if ($form->isSubmitted() && $form->isValid()) {
                    // pour le cv
                    $CVFile = $form->get('CV')->getData();

                    if ($CVFile) {
                        $originalFilename = pathinfo($CVFile->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$CVFile->guessExtension();
                        try {
                            $CVFile->move(
                                $this->getParameter('cv_directory'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }
                        $user->setCV($newFilename);
                    }

                    // pour la photo du profil
                    $PhotoFile = $form->get('Photo')->getData();

                    if ($PhotoFile) {
                        $originalPhotoName = pathinfo($PhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalPhotoName);
                        $newPhotoName = $safePhotoName.'-'.uniqid().'.'.$PhotoFile->guessExtension();
                        try {
                            $PhotoFile->move(
                                $this->getParameter('photo_directory'),
                                $newPhotoName
                            );
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }
                        $user->setPhoto($newPhotoName);
                    }
                    $this->getDoctrine()->getManager()->flush();
                    
                    return $this->redirectToRoute('user_show');
                }
        
                return $this->render('user/edit.html.twig', [
                    'user' => $candidat,
                    'form' => $form->createView(),
                ]);
            } else {
                return $this->redirectToRoute('user_show');
            }
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
