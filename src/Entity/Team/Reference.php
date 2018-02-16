<?php

namespace App\Entity\Team;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Reference
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class Reference
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $link;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $doneAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param null|string $link
     *
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDoneAt(): ?string
    {
        return $this->doneAt;
    }

    /**
     * @param null|string $doneAt
     *
     * @return $this
     */
    public function setDoneAt($doneAt)
    {
        $this->doneAt = $doneAt;

        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->name;
    }
}
