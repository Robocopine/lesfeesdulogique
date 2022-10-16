<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Form\IngredientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameFr')
            ->add('nameNl')
            ->add('nameEn')
            ->add('nameDe')
            ->add('descriptionFr')
            ->add('descriptionNl')
            ->add('descriptionEn')
            ->add('descriptionDe')
            ->add('ingredient', CollectionType::class, [
                'entry_type' => IngredientType::class,
                'allow_add' => true,
                'allow_delete' => true
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
