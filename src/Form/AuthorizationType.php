<?php

namespace App\Form;

use App\Entity\Authorization;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AuthorizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class,[
                    'widget' => 'single_text',


                    /*'years' => range(date('Y'), date('Y')+100),
                    'months' => range(date('m'), 12),
                    'days' => range(date('d'), 31),*/

                ]
            )
            ->add('hours', ChoiceType::class, [
                'choices' => [
                    '30min' => 0.3,
                    '1 h 30 min ' => 1.3,
                    '2 h' => 2,
                    '2 h 30 min ' => 2.3,
                    '3 h' => 3,
                    '3 h 30 min ' => 3.3,
                    'Demi journée' => 4,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Authorization::class,
        ]);
    }
}
