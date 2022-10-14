<?php

namespace App\Form;

use App\Entity\Substance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubstanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameFr', TextType::class, [ 'label' => 'Composant (FR)', 'attr' => ['placeholder' => 'Entrez le nom du composant en français' ]])
            ->add('nameNl', TextType::class, ['required' => false, 'label' => 'Composant (NL)', 'attr' => ['placeholder' => 'Entrez le nom du composant en néerlandais' ]])
            ->add('nameEn', TextType::class, ['required' => false, 'label' => 'Composant (EN)', 'attr' => ['placeholder' => 'Entrez le nom du composant en anglais' ]])
            ->add('nameDe', TextType::class, ['required' => false, 'label' => 'Composant (DE)', 'attr' => ['placeholder' => 'Entrez le nom du composant en allemand' ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Substance::class,
        ]);
    }
}
