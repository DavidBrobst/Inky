<?php

namespace Inky\CourseBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LessonEditType extends LessonType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->remove('date');
	}
	public function getName()
	{
		return 'inky_coursebundle_lessonedittype';
	}
}
