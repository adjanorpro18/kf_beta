<?php

namespace App\Form;

use App\Data\SearchData;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr'=> [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                //'label' => 'Catégories',
                'required' => false,
                //'expanded' => false,
                //'multiple' => true,
                'placeholder' => 'Choisir une catégorie',
                'choice_label' => function ($category){return $category->getName();}
            ])

            // Filtre par date
            ->add('min',DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date minimum',
                'required'=> false
            ])
            //
            //
            // [
            //    'label' => false,
            //  'required' => false,
            //'attr' => [
            //'placeholder' => 'Date minimum']
            //])

            //->add('max', Date::CLASS_CONSTRAINT, [
            //  'label' => false,
            //'required' => false,
            //'attr' => [
            //  'placeholder' => 'Date maximum']
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return'';
    }
}
