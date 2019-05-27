<?php

namespace App\Repository;

use App\Entity\ListMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;



class ListMovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ListMovie::class);
    }

    
	
	/**
     * @param $keyWord string
     * @param $userId int
     * @return ListMovie[]
     */
    public function findLikeId($keyWord, $userId): array
    {	
		$qb = $this->createQueryBuilder('lm');
        // alias 'lm' with current class (ListMovie)
		$res =	$qb
        ->leftJoin('lm.user', 'lmu')
        // left join and alias
        ->andWhere('lm.name LIKE :tempLm
                AND lmu.id = :userIdTemp')
        // give value (place holder) to 'u.title' and 'lum.id'
		->setParameter('tempLm',"%$keyWord%") // = '%'.$keyWord.'%'
        ->setParameter('userIdTemp', $userId)
        // give real value to place holder
		->getQuery()
		->getResult();//quand on attend result

        return $res;
		//return $qb->execute();//quand il y a un changement
    }
    
    /**
     * @param $keyWord string
     * @param $userId int
     * @return ListMovie[]
     */
    public function findLikeAll($keyWord): array
    {	
		$qb = $this->createQueryBuilder('lm');
		$res =	$qb
        ->andWhere('lm.name LIKE :tempLm')
		->setParameter('tempLm',"%$keyWord%") // = '%'.$keyWord.'%'
		->getQuery()
		->getResult();//quand on attend result

        return $res;
		//return $qb->execute();//quand il y a un changement
    }	

}
