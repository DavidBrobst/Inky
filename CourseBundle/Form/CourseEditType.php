<?php

namespace Inky\CourseBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseEditType extends CourseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	public function getName()
	{
		return 'inky_coursebundle_courseedittype';
	}
}
