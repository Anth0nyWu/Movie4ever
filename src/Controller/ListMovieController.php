<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\ListMovie;
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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
	
	/**
	 * Replaces an ListMovie resource
	 */
	 
	public function patchListMovie(int $listMovieId, Request $request, EntityManagerInterface $em) : View
	{
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);		
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!!!');
        }
		
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
	
	/**
	 * Deletes an ListMovie resource
	 */
	public function deleteListMovie(int $listMovieId, EntityManagerInterface $em) : View
	{
		$listMovie = $em->getRepository(ListMovie::class)->find($listMovieId);
		if (!$listMovie) {
            throw new EntityNotFoundException('ListMovie with id '.$listMovieId.' does not exist!!!');
        }
		
		$em->remove($listMovie);
		$em->flush();
		
		// In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
		return View::create(["delete"], Response::HTTP_NO_CONTENT);
		
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
	
}
