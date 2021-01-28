<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message')
           // ->add('createdAt')
          // ->add('validate')
           // ->add('user', EntityType::class,[
               // 'class'=>User::class,
               //'choice_label'=> function($user){
        //return $user->getPseudo();}
         //  ])

            //->add('activity1')
           // ->add('comments', TextType::class,[
             //  'label' => 'Commentaire'
           //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
