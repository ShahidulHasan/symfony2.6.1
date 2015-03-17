<?php

namespace Symfony\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupFormType extends AbstractType
{
    private $class;
    private $permissionBuilder;

    public function __construct($class, $permissionBuilder)
    {
        $this->class = $class;
        $this->permissionBuilder = $permissionBuilder;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array(
            'label' => 'Name',
            'attr'  => array('class' => 'span5')
        ));

        $builder->add('description', 'textarea', array(
            'label'    => 'Description',
            'required' => false,
            'attr'     => array('class' => 'span5', 'rows' => 3)
        ));

        $builder->add('roles', 'choice', array(
            'choices'  => $this->permissionBuilder->getPermissionHierarchyForChoiceField(),
            'multiple' => true,
            'attr'     => array('id' => 'my_multi_select2')
        ));

        $builder->add('submit', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'group',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fos_user_group';
    }
}
