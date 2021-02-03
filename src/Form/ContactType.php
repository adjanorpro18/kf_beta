<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;


class ContactType extends AbstractType
{
    public const HONEY_FIELD = 'information';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required'=> true
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet'
            ])
            ->add('message', TextareaType::class , [
                'label' => 'Message',
                'attr'=> [
                    'placeholder' => 'Votre message']
            ])
            ->add(self::HONEY_FIELD, TextType::class, [
                'required' => false
            ]);
        $builder->setMethod(Request::METHOD_POST)

        ;
    }


}
