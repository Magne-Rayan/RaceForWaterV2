<?php

namespace App\Form;

use App\Entity\Corps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class CorpsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('organe');


$builder->add('image', FileType::class, [
    'label' => 'Image (fichiers JPG, PNG ou GIF uniquement)',

    // Non requis par défaut pour éviter l'erreur si aucun fichier n'est soumis
    'required' => false,

    // Ajout des contraintes pour limiter aux types d'image autorisés
    'constraints' => [
        new File([
            'maxSize' => '2M', // Limite de taille, ici 2 Mo
            'mimeTypes' => [
                'image/jpeg',
                'image/png',
                'image/gif',
            ],
            'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, PNG ou GIF uniquement).',
        ]),
    ],
])
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Corps::class,
        ]);
    }
}
