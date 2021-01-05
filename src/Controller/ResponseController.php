<?php

namespace App\Controller;

use App\Entity\Response;
use App\Form\ResponseType;
use App\Repository\AdRepository;
use App\Repository\ResponseRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/response")
 */
class ResponseController extends AbstractController
{
    /**
     * @Route("/", name="response_index", methods={"GET"})
     */
    public function index(ResponseRepository $responseRepository): HttpResponse
    {
        return $this->render('response/index.html.twig', [
            'responses' => $responseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="response_new", methods={"GET","POST"})
     */
    public function new(Request $request): HttpResponse
    {
        $response = new Response();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($response);
            $entityManager->flush();

            return $this->redirectToRoute('response_index');
        }

        return $this->render('response/new.html.twig', [
            'response' => $response,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newFromAd", name="response_new_from_ad", methods={"GET","POST"})
     */
    public function newFromAd(Request $request, AdRepository $adRepository){

        //get current user
        $user = $this->getUser();

        //get ad
        $data = json_decode($request->getContent(), true);
        $ad = $adRepository->findOneBy(['id' => $data['responseObj']['adId']], null);

        //store response
        $response = new Response();
        $response->setUser($user);
        $response->setContent($data['responseObj']['content']);
        $response->setAd($ad);
        $response->setDate(new DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($response);
        $entityManager->flush();

        //flash message
        $this->addFlash('warning', 'La candidature a bien été enregistrée.');

        /*
        //send mail to ad author
        new Mail(
            null,
            "appmedicalipssi@gmail.com",
            $user->getMail(),
            null,
            null,
            "Mot de passe oublié",
            "Bonjour, Vous avez souhaité renouveler votre mot de passe pour accéder à votre compte. Pour cela, veuillez vous rendre sur le lien suivant: " . $url,
            $mailRepository,
            $mailer,
            $entityManager,
            $user
        );
        */

        return new JsonResponse(['success' => 1]);
    }

    /**
     * @Route("/self", name="response_self", methods={"GET"})
     */
    public function self(ResponseRepository $responseRepository): HttpResponse
    {
        $user = $this->getUser();

        return $this->render('response/self.html.twig', [
            'responses' => $responseRepository->findBy(['user' => $user]),
        ]);


    }

    /**
     * @Route("/{id}", name="response_show", methods={"GET"})
     */
    public function show(Response $response): HttpResponse
    {
        return $this->render('response/show.html.twig', [
            'response' => $response,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="response_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Response $response): HttpResponse
    {
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('response_index');
        }

        return $this->render('response/edit.html.twig', [
            'response' => $response,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="response_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Response $response): Response
    {
        if ($this->isCsrfTokenValid('delete'.$response->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($response);
            $entityManager->flush();
        }

        return $this->redirectToRoute('response_index');
    }

}
