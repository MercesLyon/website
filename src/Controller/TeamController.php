<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Team;
use App\Form\Type\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TeamController
 * @package App\Controller
 */
class TeamController extends Controller
{
    /**
     * @Route("/team", name="team", methods={"GET"})
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTeamAction(EntityManagerInterface $entityManager)
    {
        $team = $entityManager->getRepository(Team::class)->findAll();
        shuffle($team);

        return $this->render('team.html.twig', ['team' => $team]);
    }
}
