<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 11/12/2018
 * Time: 13:18
 */

namespace App\Membre;


use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'style' => 'min-width: 250px;margin-bottom: 5px;'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'style' => 'min-width: 250px;margin-bottom: 5px;'
                ]
            ])
            ->add('roles', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Role',
                    'style' => 'min-width: 250px;margin-bottom: 5px;'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'style' => 'min-width: 250px;margin-bottom: 5px;'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'style' => 'min-width: 250px;margin-bottom: 5px;'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class
        ]);
    }
}
