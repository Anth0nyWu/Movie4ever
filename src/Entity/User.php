<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 */
class User implements UserInterface
{
    /**
     */
    private $id;

    /**
     */
    private $email;

    /**
     */
    private $roles = [];

    /**
     * @var string The hashed password
     */
    private $password;
    
    /**
     * @var arraycollection
     * a user has many lists of movies
     */
    private $listMovies;
    

    //===========================================
    //Getters & Setters
    //===========================================
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
  

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        // $password = $encoder->encodePassword($this, $password);
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    
    /*
     * @return ArrayCollection
     */
    public function getListMovies() //:ArrayCollection
    {
        return $this->listMovies;
        
    }
    
    /**
     * @param ArrayCollection $listMovies
     */
	public function setListMovies(ArrayCollection $listMovies): void
	{
		$this->listMovies = $listMovies;
	}
    
}
