<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class ItemPostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('category', ChoiceType::class, [
                'placeholder' => 'Please select a category',
                'choices' => [
                    "TV's, Tablets, Entertainment" => "TV's, Tablets, Entertainment",
                    'Furnishings' => 'Furnishings',
                    'Laptops' => 'Laptops',
                    'Text Books' => 'Text Books',
                    'School Supplies' => 'School Supplies',
                    'Tutoring Services' => 'Tutoring Services',
                    'Roommate Wanted' => 'Roommate Wanted',
                    'Misc' => 'Misc'
                ]
            ])
            ->add('photoList', FileType::class, array('multiple' => true,'label' => 'Photo'))

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ItemPost'
            
        ));
    }
}
