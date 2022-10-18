<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Form\IngredientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameFr', TextType::class, [ 'label' => 'Nom (FR)', 'attr' => ['placeholder' => 'Entrez le nom du composant en français' ]])
            ->add('nameNl', TextType::class, ['required' => false, 'label' => 'Nom (NL)', 'attr' => ['placeholder' => 'Entrez le nom du composant en néerlandais' ]])
            ->add('nameEn', TextType::class, ['required' => false, 'label' => 'Nom (EN)', 'attr' => ['placeholder' => 'Entrez le nom du composant en anglais' ]])
            ->add('nameDe', TextType::class, ['required' => false, 'label' => 'Nom (DE)', 'attr' => ['placeholder' => 'Entrez le nom du composant en allemand' ]])
            ->add('descriptionFr', TextareaType::class, ['required' => false, 'label' => 'Description (FR)', 'attr' => ['placeholder' => 'Entrez la description du composant en français' ]])
            ->add('descriptionNl', TextareaType::class, ['required' => false, 'label' => 'Description (NL)', 'attr' => ['placeholder' => 'Entrez la description du composant en néerlandais' ]])
            ->add('descriptionEn', TextareaType::class, ['required' => false, 'label' => 'Description (EN)', 'attr' => ['placeholder' => 'Entrez la description du composant en anglais' ]])
            ->add('descriptionDe', TextareaType::class, ['required' => false, 'label' => 'Description (DE)', 'attr' => ['placeholder' => 'Entrez la description du composant en allemand' ]])
            ->add('ingredient', CollectionType::class, [
                'label' => 'Ingrédients',
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
