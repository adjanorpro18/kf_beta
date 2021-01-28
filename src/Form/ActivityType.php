<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Publics;
use App\Entity\State;
use App\Entity\TypeActivity;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class,[
                'label'=> "Nom de l'activité"
            ])
            ->add('description', CKEditorType::class,[
                'label'=> 'Description : '
            ])

            ->add('category', EntityType::class,[
                'class'=> Category::class,
                'label'=> 'Catégorie: ',
                'placeholder' => 'Choisir une catégorie',
                'choice_label'=> function($category){
                    return $category->getName();
                },
            ])


            ->add('publics', EntityType::class,[
                'class'=>Publics::class,
                'label'=> 'Publics : ',
                'placeholder' => 'Choisir un public ',
                'multiple'=> true,

            ])


            ->add('typeActivity', EntityType::class,[
                'class'=>TypeActivity::class,
                'choice_label'=>'name',
                'placeholder' => 'Choisir un type de l\'activité',
                'label'=>'Type d\'Activité :'
            ])

            ->add('pictures', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'multiple'=> true,
            ])

           // ->add('comments')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}