<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;



class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    
	
	/**
     * @param $keyWord
     * @return Movie[]
     */
    public function findLike($keyWord): array
    {		
		$qb = $this->createQueryBuilder('u');
		$res =	$qb->where($qb->expr()->like('u.title', ':toto'))
		->setParameter('toto',"%$keyWord%") // = '%'.$keyWord.'%'
		->getQuery()
		->getResult();//quand on attend result

        return $res;
		//return $qb->execute();//quand il y a un changement
    }
    	
    /**
     * @param $keyWord
     * @return Movie[]
     */
    public function findStart($keyWord): array
    {		
		$qb = $this->createQueryBuilder('u');
		$res =	$qb->where($qb->expr()->like('u.title', ':toto'))
		->setParameter('toto',"$keyWord%") // = '%'.$keyWord.'%'
		->getQuery()
		->getResult();//quand on attend result

        return $res;
		//return $qb->execute();//quand il y a un changement
    }
}
