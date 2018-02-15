<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package AppBundle\Controller\Admin
 *
 * @Route("/admin")
 */
class SecurityController extends Controller
{
    /**
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/login", name="admin_login", methods={"GET", "POST"})
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('admin');
        }

        /** @var \Symfony\Component\Security\Core\Exception\AuthenticationException $exception */
        $exception = $authenticationUtils->getLastAuthenticationError();

        return $this->render(
            'admin/login.html.twig',
            [
                'lastUsername' => $authenticationUtils->getLastUsername(),
                'error'        => $exception ? $exception->getMessage() : null,
            ]
        );
    }
}
