<?php

namespace App\Controller\Admin;

use App\Entity\Tuto;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TutoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tuto::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            ImageField::new('image', 'Image')
            ->setBasePath('uploads/') //le repertoire ou l image va etre telecharge
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]') //renomme l image
            ->setRequired(true),
        ];

         $slug = SlugField::new('slug')->setTargetFieldName('name');

         $name = TextField::new('name', 'Titre')
             ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 255
                ]
             ]);

        $subtitle = TextField::new('subtitle', 'sous-titre')
            ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 255
                ]
            ]);

        $video = TextField::new('video', 'Video')
            ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 255
                ]
            ]);

        $link = TextField::new('link', 'lien')
            ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 255
                ]
            ]);

        $description = TextEditorField::new('description', 'description');

        $fields[] = $name;
        $fields[] = $subtitle;
        $fields[] = $slug;
        $fields[] = $video;
        $fields[] = $link;
        $fields[] = $description;

             return $fields;
    }

}
