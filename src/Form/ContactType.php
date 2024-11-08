<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\Length(min: 5),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('subject', TextType::class, [
                'constraints' => [
                    new Assert\Length(min: 10),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new Assert\Length(min: 20),
                    new Assert\NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
