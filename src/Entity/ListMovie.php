<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class List_Movie
 * @package App\Entity\Movie
 */
Class ListMovie
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
	private $name;	//nom de liste
	
	/**
     * @var string
     */
	private $description;	//introduction
	
	/**
     * Many Lists have Many Films.
	 * 
     */
    private $movies;
	
	//====================================
	//fonctions
	//====================================
	public function __construct() {
        $this->movies = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

	/**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
	
	/**
     * @return ArrayCollection
     */
	public function getMovies()	//: ArrayCollection
	{
		return $this->movies;
	}
	
	/**
     * @param ArrayCollection $movies
     */
	public function setMovies(ArrayCollection $movies): void
	{
		$this->movies = $movies;
	}
	
	/**
     * @param Movie $movie
	 * @return ListMovie
     */
	public function addMovie(Movie $movie): ListMovie
	{		
		if(!$this->movies->contains($movie)) {
			//doctrine verifie is $movie (dans BD) existe deja dans $this->movies
			$this->movies->add($movie);
		}
		
		return $this;
	}
	
	/**
     * @param Movie $movie
	 * @return void
     */
	public function removeMovie(Movie $movie): void
	{
		$this->movies->removeElement($movie);
	}

}

	
