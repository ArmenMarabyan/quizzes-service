<?php

namespace App\Controller\Admin\Quiz;

use App\Entity\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('category');
        yield TextField::new('title');
        yield TextField::new('slug');
        yield TextField::new('duration');

        $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ]);
        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true);
        } else {
            yield $createdAt;
        }

        yield DateTimeField::new('updatedAt')->setFormTypeOptions([
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ]);
    }
}
