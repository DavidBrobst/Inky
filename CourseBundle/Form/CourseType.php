<?php

namespace Inky\CourseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'ckeditor', array(	'transformers'                 => array('strip_js', 'strip_css', 'strip_comments'),
												'toolbar'                      => array('basicstyles'),
												'toolbar_groups'               => array('basicstyles' => array(	'Bold', 'Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat',),
																						),
												'ui_color'                     => '#ffffff',
												'startup_outline_blocks'       => false,
												'width'                        => '100%',
												'height'                       => '90',
												'language'                     => 'en-au',
												'filebrowser_image_browse_url' => array('url' => 'relative-url.php?type=file',),
										)
			)
			->add('objective', 'ckeditor', array(	'transformers'                 => array('strip_js', 'strip_css', 'strip_comments'),
													'toolbar'                      => array('paragraph','links'),
													'toolbar_groups'               => array('paragraph' => array('BulletedList'),
																							'links' => array('Link','Unlink'),
																							),
													'ui_color'                     => '#ffffff',
													'startup_outline_blocks'       => false,
													'width'                        => '70%',
													'height'                       => '120',
													'language'                     => 'en-au',
													'filebrowser_image_browse_url' => array('url' => 'relative-url.php?type=file',),
										)
			)
			->add('prerequisite', 'ckeditor', array(	'transformers'                 => array('strip_js', 'strip_css', 'strip_comments'),
														'toolbar'                      => array('paragraph','links'),
														'toolbar_groups'               => array('paragraph' => array('BulletedList'),
																								'links' => array('Link','Unlink'),
																								),
														'ui_color'                     => '#ffffff',
														'startup_outline_blocks'       => false,
														'width'                        => '70%',
														'height'                       => '120',
														'language'                     => 'en-au',
														'filebrowser_image_browse_url' => array('url' => 'relative-url.php?type=file',),
										)
			)
            ->add('isPublic', 'checkbox', array('required'=>false))
			->add('image', new ImageType(), array('required' => true))
			->add('tags', 'collection', array(	'type' => new TagType(),
												'allow_add' => true,
												'allow_delete' => true,
												
										)
			)

        ;
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\CourseBundle\Entity\Course\Course'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_coursebundle_coursetype';
    }
}
