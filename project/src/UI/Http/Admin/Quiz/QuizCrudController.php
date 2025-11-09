<?php

namespace App\UI\Http\Admin\Quiz;

use App\Core\Quiz\Model\Difficulty;
use App\Core\Quiz\Model\Quiz;
use App\Core\User\Model\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use RuntimeException;

class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new RuntimeException('User is not logged in.');
        }

        return new Quiz(
            '',
            '',
            $user,
            Difficulty::Medium,
        );
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Základní nastavení');
        yield TextField::new(Quiz::TITLE);
        yield TextField::new(Quiz::SHARE_TOKEN)
            ->setDisabled();
        yield TextareaField::new(Quiz::DESCRIPTION);
        yield FormField::addTab('Otázky');
        yield CollectionField::new('questions')
            ->setEntryType(QuizQuestionType::class)
            ->allowDelete()
            ->setFormTypeOption('by_reference', false);
    }
}
