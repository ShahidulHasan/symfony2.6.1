<?php

namespace Symfony\Bundle\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('email', 'email', array(
                'label' => 'form.email', 'translation_domain' => 'FOSUserBundle'
            ))
            ->add('groups', 'entity', array(
                'class' => 'Symfony\Bundle\UserBundle\Entity\Group',
                'query_builder' => function(EntityRepository $groupRepository) {
                    return $groupRepository->createQueryBuilder('g')
                        ->andWhere("g.name != :group")
                        ->setParameter('group', 'Super Administrator');
                },
                'property' => 'name',
                'multiple' => true,
            ))
            ->add('submit', 'submit');

        $builder
            ->add('profile', new ProfileFormType());
    }


//            ->add('groups', 'entity', array(
//                'class' => 'Pms\UserBundle\Entity\Group',
//                'query_builder' => function(EntityRepository $er) {
//                        return $er->createQueryBuilder('g')
//                            ->andWhere("g.name != :group")
//                            ->setParameter('group', 'Super Administrator');
//                    },
//                'property' => 'name',
//                'multiple' => true,
//            ))

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Symfony\Bundle\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}
