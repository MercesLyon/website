<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController
{
    /**
     * @Route("/", name="homepage")
     *
     * @param \Twig_Environment $twig
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getHomepageAction(\Twig_Environment $twig)
    {
        return new Response($twig->render('homepage.html.twig'));
    }
}
