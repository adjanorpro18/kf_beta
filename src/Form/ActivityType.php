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
use FM\ElfinderBundle\ElFinder\ElFinder;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name')
            ->add('description', CKEditorType::class,[
                'label'=> 'Description : '
                ])

            ->add('category', EntityType::class,[
                   'class'=> Category::class,
                   'label'=> 'Catégorie: ',
                   'choice_label' =>'name',
                   'multiple' => true
           ])


            ->add('publics', EntityType::class,[
                'class'=>Publics::class,
                'choice_label'=>'name',
                'label'=> 'Publics : ',
                'multiple'=> true
            ])


            ->add('typeActivity', EntityType::class,[
                'class'=>TypeActivity::class,
                'choice_label'=>'name',
                'label'=>'Type d\'Activité :'
            ])


            ->add('pictures', FileType::class, [
                'label' => 'false',
                'mapped' => false,
                'required' => false,
                'multiple'=>true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
