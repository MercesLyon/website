<?php

namespace App\Security;

use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * Class AdminAuthenticator
 * @package AppBundle\Security
 */
class AdminAuthenticator implements AuthenticatorInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /** @var \App\Manager\UserManager */
    protected $userManager;

    /**
     * Default message for authentication failure.
     *
     * @var string
     */
    protected $failMessage = 'Invalid credentials';

    /** @var string */
    protected $parametersRoutes = [];

    /**
     * AdminAuthenticator constructor.
     *
     * @param \Symfony\Component\Routing\RouterInterface $router
     * @param \App\Manager\UserManager                   $userManager
     */
    public function __construct(RouterInterface $router, UserManager $userManager)
    {
        $this->router      = $router;
        $this->userManager = $userManager;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        $this->parametersRoutes = $this->getParametersRoutes();
        if (!isset($this->parametersRoutes['startRoute'])) {
            throw new \InvalidArgumentException(
                'route "startRoute" must be defined in the Authenticator::getParametersRoutes()'
            );
        }

        return $request->attributes->get('_route') == $this->parametersRoutes['startRoute']
            && $request->isMethod('POST');
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        // handle case when login form is a FormType
        if (null !== ($login = $request->get('login', null))) {
            return [
                'username' => $login['_username'] ?? null,
                'password' => $login['_password'] ?? null,
            ];
        }

        return [
            'username' => $request->get('_username'),
            'password' => $request->get('_password'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $userProvider->loadUserByUsername($credentials['username']);
        } catch (UsernameNotFoundException $e) {
            throw new CustomUserMessageAuthenticationException($this->failMessage);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->userManager->checkPassword($user, $credentials['password'])) {
            return true;
        }

        throw new CustomUserMessageAuthenticationException($this->failMessage);
    }

    /**
     * {@inheritdoc}
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        return new PostAuthenticationGuardToken(
            $user,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $this->parametersRoutes = $this->getParametersRoutes();

        if ($referer = $request->getSession()->get('_security.admin.target_path')) {
            return new RedirectResponse($referer);
        }

        if (!isset($this->parametersRoutes['authenticationSuccessRoute'])) {
            throw new \InvalidArgumentException(
                'route "authenticationSuccessRoute" must be defined in the Authenticator::getParametersRoutes()'
            );
        }

        $url = $this->router->generate($this->parametersRoutes['authenticationSuccessRoute']);

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $this->parametersRoutes = $this->getParametersRoutes();
        $request->getSession()->set(Security::LAST_USERNAME, $request->get('_username'));

        if (!isset($this->parametersRoutes['authenticationFailureRoute'])) {
            throw new \InvalidArgumentException(
                'route "authenticationFailureRoute" must be defined in the Authenticator::getParametersRoutes()'
            );
        }

        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate($this->parametersRoutes['authenticationFailureRoute']);

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $this->parametersRoutes = $this->getParametersRoutes();

        if (!isset($this->parametersRoutes['startRoute'])) {
            throw new \InvalidArgumentException(
                'route "startRoute" must be defined in the Authenticator::getParametersRoutes()'
            );
        }

        $url = $this->router->generate($this->parametersRoutes['startRoute']);

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @return array
     */
    protected function getParametersRoutes(): array
    {
        return [
            'authenticationSuccessRoute' => 'admin',
            'authenticationFailureRoute' => 'admin_login',
            'startRoute'                 => 'admin_login',
        ];
    }
}
