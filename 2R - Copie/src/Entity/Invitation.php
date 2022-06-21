<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvitationRepository::class)
 */
class Invitation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="invitations")
     */
    private $inviteur;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="invitationRecus")
     */
    private $invite;

    /**
     * @ORM\ManyToOne(targetEntity=Ressource::class, inversedBy="invitations")
     */
    private $ressource;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInviteur(): ?Utilisateur
    {
        return $this->inviteur;
    }

    public function setInviteur(?Utilisateur $inviteur): self
    {
        $this->inviteur = $inviteur;

        return $this;
    }

    public function getInvite(): ?Utilisateur
    {
        return $this->invite;
    }

    public function setInvite(?Utilisateur $invite): self
    {
        $this->invite = $invite;

        return $this;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): self
    {
        $this->ressource = $ressource;

        return $this;
    }
}
