<?php

namespace App\UI\Http\Admin\Quiz;

use App\Core\Quiz\Model\QuizQuestion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuizQuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuizQuestion::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
