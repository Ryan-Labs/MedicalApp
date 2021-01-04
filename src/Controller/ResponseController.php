<?php

namespace App\Controller;

use App\Entity\Response;
use App\Form\ResponseType;
use App\Repository\AdRepository;
use App\Repository\ResponseRepository;
use Psr\Log\LoggerInterface;
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

        //récupérer le currentUser
        $user = $this->getUser();

        //récupérer l'annonce
        $data = json_decode($request->getContent(), true);
        $ad = $adRepository->findOneBy(['id' => $data['responseObj']['adId']], null);

        //enregistrer la reponse
        $response = new Response();
        $response->setUser($user);
        $response->setContent($data['responseObj']['content']);
        $response->setAd($ad);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($response);
        $entityManager->flush();


        return new JsonResponse(['success' => 1]);
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
