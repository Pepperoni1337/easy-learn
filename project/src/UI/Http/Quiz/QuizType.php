<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quiz Name',
                'attr' => [
                    'placeholder' => 'Enter a name for your quiz',
                ],
            ])
            ->add('prompt', TextareaType::class, [
                'label' => 'Quiz Topic/Prompt',
                'attr' => [
                    'placeholder' => 'Enter a topic or prompt for generating questions',
                    'rows' => 5,
                ],
            ])
            ->add('size', EnumType::class, [
                'label' => 'Quiz Size',
                'class' => QuizSize::class,
                'choices' => QuizSize::cases(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizDto::class,
        ]);
    }
}
