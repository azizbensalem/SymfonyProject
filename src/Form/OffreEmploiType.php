<?php

namespace App\Form;

use App\Entity\OffreEmploi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreEmploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom_offre')
            ->add('Description')
            ->add('Date_Debut')
            ->add('Date_Fin')
            ->add('Exigences')
            ->add('Nbr_Places')
            ->add('CategorieOffre')
            ->add('responsabilites')
            ->add('benefices')
            ->add('statut')
            ->add('location')
            ->add('salaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreEmploi::class,
        ]);
    }
}
