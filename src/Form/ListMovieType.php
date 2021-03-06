<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\ListMovie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListMovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('listOfFilm', CollectionType::class, array(
				'allow_add' => true,
				'allow_delete' => true,
				'property_path' => 'movies',
				'entry_type' => EntityType::class,//entityType le connais comme Movie et redonner path listOfFilm=>movies
				'entry_options'=> array('class' => Movie::class)
		));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ListMovie::class,
			'csrf_protection' => false,//'AppBundle\Entity\Programmer'
        ));
    }



}