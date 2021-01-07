<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Repository\ProfessionRepository;
use App\Repository\ResponseRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ad")
 */
class AdController extends AbstractController
{
    /**
     * @Route("/", name="ad_index", methods={"GET"})
     */
    public function index(AdRepository $adRepository, ProfessionRepository $professionRepository): Response
    {
        return $this->render('ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
            'professions' => $professionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ad = new Ad();
        $user = $this->getUser();

        $form = $this->createForm(AdType::class, $ad);
        $form->get('profession')->setData($user->getProfessions()[0]);
        $form->get('contact')->setData($user);
        $form->get('phoneNumber')->setData($user->getPhoneNumber());
        $form->get('mail')->setData($user->getMail());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach ($images as $image){
                $this->persistImage($image, $ad);
            }

            $ad->setUser($user);
            $ad->setStatus('ACTIVE');
            $ad->setDate(new DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    private function persistImage($image, $ad)
    {
        $file = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move($this->getParameter('images_directory'), $file);

        $img = new Image();
        $img->setName($file);
        $ad->addImage($img);
    }

    /**
     * @Route("/self", name="ad_self", methods={"GET"})
     */
    public function self(AdRepository $adRepository): Response
    {
        $user = $this->getUser();

        return $this->render('ad/self.html.twig', [
            'ads' => $adRepository->findBy(['user' => $user], ['date' => 'DESC'])
        ]);

    }

    /**
     * @Route("/{id}", name="ad_show", methods={"GET"})
     */
    public function show(Ad $ad, ResponseRepository $responseRepository): Response
    {
        $hasResponse = false;
        $user = $this->getUser();

        $profession = '';
        $phoneNumber = '';
        $mail = '';

        $sameUser = false;

        if ($user) {

            //return if user has already response
            $response = $responseRepository->findOneBy(['user' => $user, 'ad' => $ad], null);
            if ($response) {
                $hasResponse = true;
            }

            //return user entity fields
            $profession = $user->getProfessions()[0];
            $phoneNumber = $user->getPhoneNumber();
            $mail = $user->getMail();

            if ($user->getId() == $ad->getUser()->getId()) {
                $sameUser = true;
            }

        }

        $responses = $responseRepository->findBy(['ad' => $ad]);

        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
            'hasResponse' => $hasResponse,
            'profession' => $profession,
            'phoneNumber' => $phoneNumber,
            'mail' => $mail,
            'sameUser' => $sameUser,
            'responses' => $responses,
            'currentUser' => $user
        ]);

    }

    /**
     * @Route("/{id}/edit", name="ad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ad $ad): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        if ($this->getUser()->getId() != $ad->getUser()->getId()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach ($images as $image){
                $this->persistImage($image, $ad);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/image/{id}", name="ad_delete_image", methods={"DELETE"})
     */
    public function deleteImageFromAd(Image $image, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            unlink($this->getParameter('images_directory') . '/' . $image->getName());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();

            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['error' => 'Invalid token'], 400);
    }

    /**
     * @Route("/{id}", name="ad_close", methods={"POST"})
     */
    public function close(Request $request, Ad $ad): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        if ($this->getUser()->getId() != $ad->getUser()->getId()) {
            return $this->redirectToRoute('home');
        }

        $ad->setStatus("CLOSED");
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('ad_self');
    }

    /**
     * @Route("/{id}", name="ad_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ad $ad): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        if ($this->getUser()->getId() != $ad->getUser()->getId()) {
            return $this->redirectToRoute('home');
        }

        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ad_index');
    }
}
