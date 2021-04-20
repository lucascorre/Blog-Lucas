<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author',TextType::class)
            ->add('title',TextType::class)
            ->add('category',ChoiceType::class,
            [
                'choices' =>
                [
                    'Muscle Car' => 'Muscle Car',
                    'Super Car' => 'Super Car',
                    'Electric Car' => 'Electric Car',
                    'Sport' => 'Sport',
                ]
            ])
            ->add('content', TextareaType::class)
            ->add('summary', TextareaType::class)
            ->add('image', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
