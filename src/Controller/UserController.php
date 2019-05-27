<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Movie;
use App\Form\MovieType;
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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Collections\ArrayCollection;



final class UserController extends FOSRestController
{    
	/**
     * Creates a User
     * @param Request $request
     * @return View
     */
    public function postUser(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): View
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);//build form
		$data = json_decode($request->getContent(), true);// true for get table relative		
        $data["password"] = $encoder-> encodePassword($user, $data["password"]);//encode password
        // print_r($data);
		$form->submit($data);//remplir table
		if(!$form->isValid()) {
			throw new BadRequestHttpException($form->getErrors(true));
		}
		
		$em->persist($user);
		$em->flush();
		
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($user, Response::HTTP_CREATED);
    }	
		
	/**
	 * Retrieves a User resource
	 */
	public function getUserById(int $userId, EntityManagerInterface $em)/* : View */
	{
		$user = $em->getRepository(User::class)->find($userId);
		if (!$user) {
            throw new EntityNotFoundException('Uer with id '.$userId.' does not exist !');
        }
		
		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($user, Response::HTTP_OK);
        // return $this->handleView($this->view($user, Response::HTTP_OK));
	}
	
	/**
	 * Replaces an Movie resource
	 */
	/* public function putMovie(int $movieId, Request $request, EntityManagerInterface $em) : View
	{
		$movie = $em->getRepository(Movie::class)->find($movieId);
		if (!$movie) {
            throw new EntityNotFoundException('Movie with id '.$movieId.' does not exist!');
        }
		
		$form = $this->createForm(MovieType::class, $movie);
		$data = json_decode($request->getContent(), true);		
		$form->submit($data);
		if(!$form->isValid()) {
			throw new BadRequestHttpException($form->getErrors(true));
		}
		
		$em->persist($movie);
		$em->flush();

		// In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
		return View::create($movie, Response::HTTP_OK);
	} */
	
	/**
	 * Replaces an Movie resource
	 */
	/* public function patchMovie(int $movieId, Request $request, EntityManagerInterface $em) : View
	{
		$movie = $em->getRepository(Movie::class)->find($movieId);
		if (!$movie) {
            throw new EntityNotFoundException('Movie with id '.$movieId.' does not exist!!!');
        }	

        $form = $this->createForm(MovieType::class, $movie);
		$data = json_decode($request->getContent(), true);
		$form->submit($data, false);//false pour eviter remplace par null quand patch
		if(!$form->isValid()) {
			throw new BadRequestHttpException($form->getErrors(true));
		}
			
		$em->persist($movie);
		$em->flush();
		
		// In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
		return View::create($movie, Response::HTTP_OK);
	} */
	
	/**
	 * Deletes an User resource
	 */
	public function deleteUser(int $userId, EntityManagerInterface $em) : View
	{
		$user = $em->getRepository(User::class)->find($userId);
		if (!$user) {
            throw new EntityNotFoundException('User with title '.$userId.' does not exist !');
        }
        
        if ($this->getUser()==$user) {
            echo("deleted");
            $em->remove($user);
            $em->flush();
            
            // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
            return View::create(["delete"], Response::HTTP_NO_CONTENT);		
        }
        else {
            throw new AccessDeniedException("Access Denied");
        }
		
	}
	
	/**
	 * findMovie
	 */
	 /* public function findMovie(Request $request, EntityManagerInterface $em): View
	{		
		$search = [];
		$keySearch = [];
		
		if($request->query->get('title')) {
			$search['title'] = $request->query->get('title');
		}
		if($request->query->get('annee')) {
			$search['annee'] = $request->query->get('annee');
		}
		$movies = $em->getRepository(Movie::class)->findBy($search);
		
		if((!strcmp($request->query->get('type'),'start')) && ($request->query->get('keyWord'))) {
			$keySearch['keyWord'] = $request->query->get('keyWord');
			$movies = $em->getRepository(Movie::class)->findBeginWith($keySearch['keyWord']);
			
		}
		
		// In case our GET was a success we need to return a 200 HTTP OK response with the request object
		return View::create($movies, Response::HTTP_OK);	
	} */
}
