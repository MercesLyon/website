<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Entity\Admin
 *
 * @ORM\Entity()
 */
class User implements UserInterface, \Serializable, EquatableInterface
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $salt;

    /**
     * @var string|null
     */
    private $plainPassword;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     *
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * @return $this
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->email,
                $this->password,
                $this->salt,
            ]
        );
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->salt
            ) = unserialize($serialized);
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user = null)
    {
        return $user && $this->getUsername() === $user->getUsername();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }
}
