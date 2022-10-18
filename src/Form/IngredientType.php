<?php

namespace App\Form;

use App\Entity\Substance;
use App\Entity\Ingredient;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('substance', EntityType::class, [
                'label' => 'Composant',
                'class' => Substance::class,
                'choice_label' => 'nameFr',
                'placeholder' => 'Supprimer',
                'required' => false,
                'attr' => ['class' => 'composant-path' ]
            ])
            ->add('quantity',TextType::class, [ 'label' => 'Quantité', 'attr' => ['placeholder' => 'Entrez la quantité de l\'ingrédient']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
