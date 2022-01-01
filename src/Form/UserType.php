<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextareaType::class, [

             'label' => 'Prénom'])
            ->add('lastName', TextareaType::class, [

                'label' => 'Nom de famille'])

            ->add('email')
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Employée'          => 'ROLE_USER',
                    'Ressource humaine' => 'ROLE_HR',
                    'Responsable'       => 'ROLE_RESPONSABLE',
                ],

            ])
            ->add('adresse')
            ->add('departement',ChoiceType::class, [
        'choices'  => [
            'Informatique' => 'Informatique',
            'Ressource Humaine' => 'Ressource Humaine',
            'Maintenance' => 'Maintenance',
            'Réseaux'     =>'Réseaux',
        ]])

        ;

        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
