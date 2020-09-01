<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Courses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CoursesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', )
            ->add('image',FileType::class,['required' =>false])
            ->add('content', CKEditorType::class)
            ->add('description')
            ->add('categories')
        ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Courses::class,
        ]);
    }
}
