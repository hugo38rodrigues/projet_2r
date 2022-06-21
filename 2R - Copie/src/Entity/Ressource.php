<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
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
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCrea;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $exploite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $demarre;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="ressources",cascade={"persist"})
     */
    private $Createur;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="Ressource")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="ressource")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="ressource")
     */
    private $files;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="ressources")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="ressources")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Acces::class, inversedBy="ressources")
     */
    private $acces;

    /**
     * @ORM\OneToMany(targetEntity=Lien::class, mappedBy="ressource",cascade={"remove"})
     */
    private $utilisateurLie;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="ressource")
     */
    private $invitations;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrConsultation;

    public function __construct()
    {
        $this->favoris = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->utilisateurLie = new ArrayCollection();
        $this->dateCrea = new \DateTime('now');
        $this->invitations = new ArrayCollection();
        $this->nbrConsultation = 0;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDateCrea(?\DateTimeInterface $dateCrea): self
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getExploite(): ?bool
    {
        return $this->exploite;
    }

    public function setExploite(?bool $exploite): self
    {
        $this->exploite = $exploite;

        return $this;
    }

    public function getDemarre(): ?bool
    {
        return $this->demarre;
    }

    public function setDemarre(?bool $demarre): self
    {
        $this->demarre = $demarre;

        return $this;
    }

    public function getCreateur(): ?Utilisateur
    {
        return $this->Createur;
    }

    public function setCreateur(?Utilisateur $Createur): self
    {
        $this->Createur = $Createur;

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
            $message->setRessource($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getRessource() === $this) {
                $message->setRessource(null);
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
            $commentaire->setRessource($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getRessource() === $this) {
                $commentaire->setRessource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setRessource($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getRessource() === $this) {
                $file->setRessource(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getAcces(): ?Acces
    {
        return $this->acces;
    }

    public function setAcces(?Acces $acces): self
    {
        $this->acces = $acces;

        return $this;
    }

    /**
     * @return Collection|Lien[]
     */
    public function getUtilisateurLie(): Collection
    {
        return $this->utilisateurLie;
    }

    public function addUtilisateurLie(Lien $utilisateurLie): self
    {
        if (!$this->utilisateurLie->contains($utilisateurLie)) {
            $this->utilisateurLie[] = $utilisateurLie;
            $utilisateurLie->setRessource($this);
        }

        return $this;
    }

    public function removeUtilisateurLie(Lien $utilisateurLie): self
    {
        if ($this->utilisateurLie->removeElement($utilisateurLie)) {
            // set the owning side to null (unless already changed)
            if ($utilisateurLie->getRessource() === $this) {
                $utilisateurLie->setRessource(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitre();
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
            $invitation->setRessource($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getRessource() === $this) {
                $invitation->setRessource(null);
            }
        }

        return $this;
    }

    public function getNbrConsultation(): ?int
    {
        return $this->nbrConsultation;
    }

    public function setNbrConsultation(?int $nbrConsultation): self
    {
        $this->nbrConsultation = $nbrConsultation;

        return $this;
    }
}
