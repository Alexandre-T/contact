<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Form
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Form\Type;

use App\Entity\Organization;
use App\Entity\Person;
use App\Repository\OrganizationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Person form class.
 */
class PersonType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('familyName', TextType::class, [
                'label' => 'form.person.field.family-name',
                'help' => 'form.person.help.family-name',
                'attr' => [
                    'autofocus' => true,
                ],
            ])
            ->add('birthName', TextType::class, [
                'label' => 'form.person.field.birth-name',
                'help' => 'form.person.help.birth-name',
                'required' => false,
            ])
            ->add('givenName', TextType::class, [
                'label' => 'form.person.field.given-name',
                'help' => 'form.person.help.given-name',
                'required' => false,
            ])
            ->add('jobTitle', TextType::class, [
                'label' => 'form.person.field.job-title',
                'help' => 'form.person.help.job-title',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.person.field.email',
                'help' => 'form.person.help.email',
                'required' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'form.person.field.gender',
                'help' => 'form.person.help.gender',
                'choices' => [
                    //'gender.unknown' => null,
                    'gender.female' => Person::FEMALE,
                    'gender.male' => Person::MALE,
                    'gender.other' => Person::OTHER,
                ],
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'form-check-inline p-0 pt-2'],
            ])
            ->add('url', UrlType::class, [
                'label' => 'form.person.field.url',
                'help' => 'form.person.help.url',
                'required' => false,
            ])
            ->add('address', PostalAddressType::class, [
                'label' => 'form.person.field.address',
            ])
            //FIXME Complete it with an OrganizationType
            ->add('alumnus', EntityType::class, [
                'class' => Organization::class,
                'query_builder' => function (OrganizationRepository $or) {
                    return $or->createQueryBuilder('o')
                        ->orderBy('o.label', 'ASC');
                },
                'choice_label' => 'label',
                'label' => 'form.person.field.alumnus',
                'help' => 'form.person.help.alumnus',
                'required' => false,
            ])
            //FIXME Complete it with an OrganizationType
            ->add('memberOf', EntityType::class, [
                'class' => Organization::class,
                'query_builder' => function (OrganizationRepository $or) {
                    return $or->createQueryBuilder('o')
                        ->orderBy('o.label', 'ASC');
                },
                'choice_label' => 'label',
                'label' => 'form.person.field.member-of',
                'help' => 'form.person.help.member-of',
                'required' => false,
            ])
            ->add('nationality', CountryType::class, [
                'preferred_choices' => ['FR'],
                'label' => 'form.person.field.nationality',
                'help' => 'form.person.help.nationality',
                'required' => false,
            ])
        ;
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
