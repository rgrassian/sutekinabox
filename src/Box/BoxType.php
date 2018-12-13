<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/12/2018
 * Time: 17:14
 */

namespace App\Box;


use App\Entity\Box;
use App\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, Array $options)
    {
        $builder
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nom', 'ASC');
                },
                'choice_label' => function ($produit) {
                    return $produit->getNom().', '.$produit->getPrix().'€ ';
                },
                'expanded' => true,
                'multiple' => true,
                'label' => "Produits",
                'placeholder' => 'Sélectionner un ou plusieurs produits',
                'attr' => ['class' => 'form-check']
            ])
            ->add('date', DateTimeType::class, [
                'label' => "Date"
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider la box"
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Box::class,

        ]);
    }

}