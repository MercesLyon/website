<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Team
 * @package App\Entity
 *
 * @ORM\Entity()
 * @Vich\Uploadable()
 */
class Team
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
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $experience;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $jobTitle;

    /**
     * @var \App\Entity\Team\Skill[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Team\Skill", cascade={"persist", "merge"}, fetch="EXTRA_LAZY")
     */
    private $skills;

    /**
     * @var \App\Entity\Team\Certification[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Team\Certification", cascade={"persist", "merge"}, fetch="EXTRA_LAZY")
     */
    private $certifications;

    /**
     * @var \App\Entity\Team\Reference[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Team\Reference", cascade={"persist", "merge"}, fetch="EXTRA_LAZY")
     */
    private $references;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $twitter;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $linkedin;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $github;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File|null
     *
     * @Vich\UploadableField(mapping="team_pictures", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Team constructor.
     */
    public function __construct()
    {
        $this->skills         = new ArrayCollection();
        $this->certifications = new ArrayCollection();
        $this->references     = new ArrayCollection();
    }

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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExperience(): ?int
    {
        return $this->experience;
    }

    /**
     * @param int|null $experience
     *
     * @return $this
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param null|string $jobTitle
     *
     * @return $this
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return \App\Entity\Team\Skill[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param \App\Entity\Team\Skill[]|\Doctrine\Common\Collections\ArrayCollection $skills
     *
     * @return $this
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @return \App\Entity\Team\Certification[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getCertifications()
    {
        return $this->certifications;
    }

    /**
     * @param \App\Entity\Team\Certification[]|\Doctrine\Common\Collections\ArrayCollection $certifications
     *
     * @return $this
     */
    public function setCertifications($certifications)
    {
        $this->certifications = $certifications;

        return $this;
    }

    /**
     * @return \App\Entity\Team\Reference[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param \App\Entity\Team\Reference[]|\Doctrine\Common\Collections\ArrayCollection $references
     *
     * @return $this
     */
    public function setReferences($references)
    {
        $this->references = $references;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    /**
     * @param null|string $twitter
     *
     * @return $this
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    /**
     * @param null|string $linkedin
     *
     * @return $this
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getGithub(): ?string
    {
        return $this->github;
    }

    /**
     * @param null|string $github
     *
     * @return $this
     */
    public function setGithub($github)
    {
        $this->github = $github;

        return $this;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File|null
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $pictureFile
     *
     * @return $this
     */
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;

        if ($this->pictureFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     *
     * @return $this
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
