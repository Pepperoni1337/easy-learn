<?php

namespace App\UI\Http\Admin\Quiz;

use App\Core\Quiz\Model\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Základní nastavení');
        yield TextField::new(Quiz::TITLE);
        yield TextareaField::new(Quiz::DESCRIPTION);
        yield FormField::addTab('Odpovědi');
        yield CollectionField::new('questions')
            ->setEntryType(QuizQuestionType::class)
            ->allowAdd()
            ->allowDelete()
            ->setFormTypeOption('by_reference', false);
    }
}
