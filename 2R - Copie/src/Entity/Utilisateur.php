<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\AbstractType;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur extends AbstractType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $droit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaiss;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="Createur")
     */
    private $ressources;

    /**
     * @ORM\ManyToMany(targetEntity=StatRecherche::class, mappedBy="utilisateurs")
     */
    private $statRecherches;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="utilisateur")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="utilisateur")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Lien::class, mappedBy="utilisateur",cascade={"remove"})
     */
    private $RessourceLiee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="inviteur")
     */
    private $invitations;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="invite")
     */
    private $invitationRecus;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
        $this->statRecherches = new ArrayCollection();
        $this->RessourceFav = new ArrayCollection();
        $this->RessourceParticipe = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->RessourceLiee = new ArrayCollection();
        $this->actif = true;
        $this->droit = 'CitoyenConnecte';
        $this->invitations = new ArrayCollection();
        $this->invitationRecus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDroit(): ?string
    {
        return $this->droit;
    }

    public function setDroit(?string $droit): self
    {
        $this->droit = $droit;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(?\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setCreateur($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getCreateur() === $this) {
                $ressource->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatRecherche[]
     */
    public function getStatRecherches(): Collection
    {
        return $this->statRecherches;
    }

    public function addStatRecherch(StatRecherche $statRecherch): self
    {
        if (!$this->statRecherches->contains($statRecherch)) {
            $this->statRecherches[] = $statRecherch;
            $statRecherch->addUtilisateur($this);
        }

        return $this;
    }

    public function removeStatRecherch(StatRecherche $statRecherch): self
    {
        if ($this->statRecherches->removeElement($statRecherch)) {
            $statRecherch->removeUtilisateur($this);
        }

        return $this;
    }


    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUtilisateur() === $this) {
                $message->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUtilisateur() === $this) {
                $commentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lien[]
     */
    public function getRessourceLiee(): Collection
    {
        return $this->RessourceLiee;
    }

    public function addRessourceLiee(Lien $ressourceLiee): self
    {
        if (!$this->RessourceLiee->contains($ressourceLiee)) {
            $this->RessourceLiee[] = $ressourceLiee;
            $ressourceLiee->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRessourceLiee(Lien $ressourceLiee): self
    {
        if ($this->RessourceLiee->removeElement($ressourceLiee)) {
            // set the owning side to null (unless already changed)
            if ($ressourceLiee->getUtilisateur() === $this) {
                $ressourceLiee->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getPrenom().' '.$this->getNom();
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setInviteur($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getInviteur() === $this) {
                $invitation->setInviteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitationRecus(): Collection
    {
        return $this->invitationRecus;
    }

    public function addInvitationRecu(Invitation $invitationRecu): self
    {
        if (!$this->invitationRecus->contains($invitationRecu)) {
            $this->invitationRecus[] = $invitationRecu;
            $invitationRecu->setInvite($this);
        }

        return $this;
    }

    public function removeInvitationRecu(Invitation $invitationRecu): self
    {
        if ($this->invitationRecus->removeElement($invitationRecu)) {
            // set the owning side to null (unless already changed)
            if ($invitationRecu->getInvite() === $this) {
                $invitationRecu->setInvite(null);
            }
        }

        return $this;
    }
}
