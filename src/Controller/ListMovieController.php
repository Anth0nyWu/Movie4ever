<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\ListMovie;
use App\Entity\User;
use App\Form\ListMovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\Common\Collections\ArrayCollection;


final class ListMovieController extends FOSRestController
{    
	
	/**
     * Creates an ListMovie resource
     * @param Request $request
     * @return View
     */
    public function postListMovie(Request $request, EntityManagerInterface $em): View
    {
        $listMovie = new ListMovie();
		
		//create form
		$form = $this->createForm(ListMovieType::class, $listMovie);//build form
		//handle request
		$data = json_decode($request->getContent(), true);// true for get table relative			
        
		//submit data
		$form->submit($data);//remplir table
		//if (not valid)
		if(!$form->isValid()) {
			throw new BadRequestHttpException($form->getErrors(true));
		}
        
        //find current user & setUser
        $user = $this->getUser();
        //print_r($user);
        $listMovie->setUser($user);
        
		//saving entity && return 
		$em->persist($listMovie);
		$em->flush();
		
		// In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($listMovie, Response::HTTP_CREATED);
    }	
		
	/**
	 * Retrieves an ListMovie resource
	 */
	public function getListMovie(int $listMovieId, EntityManagerInterface $em): View
	{
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);		
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!');
        }
		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($listMovie, Response::HTTP_OK);
		
	}
	
	/**
	 * Replaces an ListMovie resource
	 */
	public function putListMovie(int $listMovieId, Request $request, EntityManagerInterface $em) : View
	{
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist !');
        }
        //find current user 
        $user = $this->getUser();
        //find user of list
        $listUser = $listMovie->getUser(); 
        
        if ($user == $listUser) {          
                    
            $form = $this->createForm(ListMovieType::class, $listMovie);//build form
            $data = json_decode($request->getContent(), true);// true for get table relative	
            $form->submit($data);//remplir table
            if(!($form->isValid()&&$form->isSubmitted())) {
                throw new BadRequestHttpException($form->getErrors(true));
            }
            
            $em->persist($listMovie);
            $em->flush();
            
            // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
            return View::create($listMovie, Response::HTTP_OK);
        }
        else {
            throw new AccessDeniedException("Access Denied");
        }
	}
	
	/**
	 * Replaces an ListMovie resource
	 */
	 
	public function patchListMovie(int $listMovieId, Request $request, EntityManagerInterface $em) : View
	{
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);		
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!!!');
        }
        
		$user = $this->getUser();
        $listUser = $listMovie->getUser(); 
		if ($user == $listUser) {
            $form = $this->createForm(ListMovieType::class, $listMovie);//build form
            $data = json_decode($request->getContent(), true);// true for get table relative
            $form->submit($data,false);//remplir table
            if(!$form->isValid()) {
                throw new BadRequestHttpException($form->getErrors(true));
            }
            
            $em->persist($listMovie);
            $em->flush();
		
            //In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
            return View::create($listMovie, Response::HTTP_OK);

        }
        else {
            throw new AccessDeniedException("Access Denied");
        }		

	}
	
	/**
	 * Deletes an ListMovie resource
	 */
	public function deleteListMovie(int $listMovieId, EntityManagerInterface $em) : View
	{
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!!!');
        }
		
        $user = $this->getUser();
        $listUser = $listMovie->getUser(); 
		if ($user == $listUser) {
            
            $em->remove($listMovie);
            $em->flush();
            
            // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
            return View::create(["delete"], Response::HTTP_NO_CONTENT);
		}
        else {
            throw new AccessDeniedException("Access Denied");
        }
        
	}
	
	/**
     * Add a film to ListMovie resource
     * @param Request $request
     * @return View
	 * 
     */
    public function addToListMovie(int $listMovieId, Request $request, EntityManagerInterface $em, ListMovieController $listMovieController)//: View
    {
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!');
        }
		
        $user = $this->getUser();
        $listUser = $listMovie->getUser(); 
		if ($user == $listUser) {            
            $movieIds = $request->request->all();//aussi getContent()
            foreach ($movieIds as $movieId) {
                $movieTemp = $em->getRepository(Movie::class)->find($movieId);
                    if (!$movieTemp) {
                        throw new EntityNotFoundException('Movie with id '.$movieId.' does not exist!!!');
                    }
                $listMovie->addMovie($movieTemp);
            }
            
            $em->persist($listMovie);
            $em->flush();
            
            //In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
            return View::create($listMovie, Response::HTTP_OK);
		}
        else {
            throw new AccessDeniedException("Access Denied");
        }
        
    }
	
	/**
     * Delete a film from ListMovie resource
     * @param Request $request
     * @return View
	 * 
     */
	public function delFromListMovie(int $listMovieId, Request $request, EntityManagerInterface $em, ListMovieController $listMovieController)//: View
    {			
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);		
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!');
        }
		
        $user = $this->getUser();
        $listUser = $listMovie->getUser(); 
		if ($user == $listUser) { 
            $listOfFilm = $listMovie->getMovies();
            $movieIds = $request->request->all();
            foreach ($listOfFilm as $filmTemp) {
                if (in_array($filmTemp->getId(),$movieIds)) {
                    $listMovie->removeMovie($filmTemp);
                }
            }
            
            $em->persist($listMovie);
            $em->flush();
            
            //In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
            return View::create($listMovie, Response::HTTP_OK);	
        }
        else {
            throw new AccessDeniedException("Access Denied");
        }
    }
	
    /**
	 * find in AllListMovie
	 */
	 public function findAllListMovie(Request $request, EntityManagerInterface $em): View
	{		
		$search = [];
		
		if($request->query->get('name')) {
			$search['name'] = $request->query->get('name');
		}
		if($request->query->get('user')) {
            $userId = $request->query->get('user');
			$search['user'] =  $em->getRepository(User::class)->find($userId);
		}
		$listMovies = $em->getRepository(ListMovie::class)->findBy($search);

		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($listMovies, Response::HTTP_OK);	
	}
        
    /**
	 * find in MyListMovie
	 */
	 public function findMyListMovie(Request $request, EntityManagerInterface $em): View
	{		
		$search = [];
		
        $search['user'] = $this->getUser();
		if($request->query->get('name')) {
			$search['name'] = $request->query->get('name');
		}
		$listMovies = $em->getRepository(ListMovie::class)->findBy($search);
		
		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($listMovies, Response::HTTP_OK);	
	}

    /**
	 * findLike in AllListMovie
	 */
	 public function findLikeAllListMovie(Request $request, EntityManagerInterface $em): View
	{		
		$search = [];

        if($request->query->get('keyWord')) {
			$search['keyWord'] = $request->query->get('keyWord');
            
            if($request->query->get('user')) {
                $userId = $request->query->get('user');
			$search['user'] =  $em->getRepository(User::class)->find($userId);
            $listMovies = $em->getRepository(ListMovie::class)->findLikeId($search['keyWord'],$search['user']);
            }
            else {
			$listMovies = $em->getRepository(ListMovie::class)->findLikeAll($search['keyWord']);
            }
        }
		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($listMovies, Response::HTTP_OK);	
	}
    
    /**
	 * findLike in MyListMovie
	 */
	 public function findLikeMyListMovie(Request $request, EntityManagerInterface $em): View
	{		
		$search = [];
        if($request->query->get('keyWord')) {
			$search['keyWord'] = $request->query->get('keyWord');
			$listMovies = $em->getRepository(ListMovie::class)->findLikeId($search['keyWord'],$this->getUser());
		}
       
		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($listMovies, Response::HTTP_OK);	
	}
    
}
