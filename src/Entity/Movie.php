<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use app\Entity\ListMovie;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;

/**
 * Class Movie
 * @package App\Entity\Movie
 */
Class Movie
{
	//================================
	//members
	//================================
	
	/**
     * @var int
     */
	private $id;

	/**
     * @var string
     */
	private $title;
	
	/**
     * @var string
     */
	private $synopsis;	//introduction
	
	/**
     * @var int
     */
	private $annee;	//annee de sortie
	
    /**
     * Many Movies have Many ListMovies.
	 */
    private $listMovies;
	
	//====================================
	//fonctions
	//====================================
	public function __construct() {
        $this->listMovies = new ArrayCollection();
    }
	
	/**
     * @return int
     */
	public function getId(): int
    {
		return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
	
	/**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

	/**
     * @return string
     */
    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    /**
     * @param string $Synopsis
     */
    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }
	
	/**
     * @return int
     */
    public function getAnnee()//: int
    {
        return $this->annee;
    }

    /**
     * @param int $Annee
     */
    public function setAnnee(string $annee): void
    {
        $this->annee = $annee;
    }
	
}
