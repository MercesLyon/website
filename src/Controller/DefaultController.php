<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHomepageAction()
    {
        $form = $this->createForm(
            ContactType::class,
            new Contact(),
            [
                'action' => $this->generateUrl('contact'),
                'method' => 'POST',
            ]
        );

        return $this->render(
            'homepage.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/contact", name="contact", condition="request.isXmlHttpRequest()", methods={"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\EntityManagerInterface      $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postContactAction(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(
            ContactType::class,
            $contact = new Contact(),
            [
                'action' => $this->generateUrl('contact'),
                'method' => 'POST',
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return new JsonResponse(
                [
                    'success' => true,
                    'html'    => $this->renderView('confirm.html.twig', ['contact' => $contact]),
                ]
            );
        }

        return new JsonResponse(
            [
                'success' => false,
                'html'    => $this->renderView('contact.html.twig', ['form' => $form->createView()]),
            ]
        );
    }
}
