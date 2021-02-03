<?php

namespace App\Form;
use App\Entity\Icon;
use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
$builder
    ->add('profile', EntityType::class, [
        'class' => Profile::class,
        'label' => 'Profile',
        'choice_label' => 'name',
    ])
//->add('icon', EntityType::class,[
        //'class'=> Icon::class,
        //'label' => 'Avatar',
       // 'choice_label'=>'file'
     //])

->add('users', EntityType::class,[
        'class'=> User::class,
        'label' => 'Ambassadeur'
    ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
$resolver->setDefaults([
    'data_class' => User::class,
]);
}
}



