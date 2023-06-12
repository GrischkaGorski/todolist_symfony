<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Todo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label'=> 'Titre de la tâche :'])
            ->add('description', TextType::class, ['label'=> 'Description de la tâche :','required' => false])
            ->add('done', CheckboxType::class, ['label'=> 'Tâche déjà faite :','required' => false])
            ->add('tags', EntityType::class, ['label'=> 'Tags associés : ', 'class' => Tag::class, 'choice_label' => 'name', 'multiple' => true, 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
