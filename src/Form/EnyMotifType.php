<?php

namespace App\Form;

use App\Entity\EnyMotif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EnyMotifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "required" => true,
                "attr" => [
                    "placeholder" => "Ecrivez le libélle ici"
                ]
            ])
            ->add('content', TextareaType::class, [
                "required" => false,
                "row_attr" => ['class' => 'text-editor'],
                "attr" => [
                    "placeholder" => "Faites une description",
                    "rows" => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnyMotif::class,
        ]);
    }
}
