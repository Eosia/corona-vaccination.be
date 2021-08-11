<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Province;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'attr' => [
                    'placeholder' => 'Votre recherche',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('provinces', EntityType::class, [
                'label' => 'Filtrer par province',
                'required' => false,
                'class' => Province::class,
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'text-left mx-auto'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Lancer la recherche',
                'attr' => [
                    'class' => 'btn-block btn-primary col-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 text-center mx-auto'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'allow_extra_fields'=> true,
            'method'=> 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {

        return '';
    }
}
