<?php

namespace App\UI\Http\Admin\Quiz;

use App\Core\Quiz\Model\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
    }


    public function createEntity(string $entityFqcn)
    {
        return new Quiz('', '');
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
