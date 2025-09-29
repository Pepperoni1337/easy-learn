<?php

declare(strict_types=1);

namespace App\UI\Http\Admin\Quiz;

use App\Core\Quiz\Model\QuizQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class QuizQuestionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestion::class,
            'error_bubbling' => false,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            QuizQuestion::QUESTION,
            null,
            [
                'label' => 'Otázka',
                'error_bubbling' => true,
            ]
        );

        $builder->add(
            QuizQuestion::ANSWER,
            null,
            [
                'label' => 'Odpověď',
                'error_bubbling' => true,
            ]
        );
    }
}