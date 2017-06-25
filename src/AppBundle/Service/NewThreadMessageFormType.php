<?php

namespace AppBundle\Service;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\UsernameFormType;

/**
 * Message form type for starting a new conversation.
 */
class NewThreadMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipient', UsernameFormType::class, array(
                'label' => 'Recipient',
                'translation_domain' => 'FOSMessageBundle'
            ))
            ->add('subject', TextType::class, array(
                'label' => 'Subject',
                'translation_domain' => 'FOSMessageBundle',
            ))
            ->add('body', TextareaType::class, array(
                'label' => 'Body',
                'translation_domain' => 'FOSMessageBundle',
                'attr' => array('style' => 'height: 200px')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'message',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'new_thread_message';
    }
}
