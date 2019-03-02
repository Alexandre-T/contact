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

namespace App\Form;

use App\Entity\Person;
use App\Form\Type\BirthNameType;
use App\Form\Type\CountryType;
use App\Form\Type\FacebookType;
use App\Form\Type\FamilyNameType;
use App\Form\Type\GenderType;
use App\Form\Type\GivenNameType;
use App\Form\Type\InstagramType;
use App\Form\Type\JobTitleType;
use App\Form\Type\LinkedInType;
use App\Form\Type\OrganizationType;
use App\Form\Type\TwitterType;
use App\Form\Type\UrlType;
use App\Form\Type\YoutubeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Person form class.
 */
class PersonForm extends AbstractType
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
            ->add('familyName', FamilyNameType::class)
            ->add('birthName', BirthNameType::class)
            ->add('givenName', GivenNameType::class)
            ->add('jobTitle', JobTitleType::class)
            ->add('email', EmailType::class, [
                'label' => 'form.field.email',
                'help' => 'form.help.email',
                'required' => false,
            ])
            ->add('gender', GenderType::class)
            ->add('url', UrlType::class)
            ->add('address', PostalAddressForm::class, [
                'label' => 'form.person.field.address',
            ])
            ->add('alumnus', OrganizationType::class, [
                'label' => 'form.field.alumnus',
                'help' => 'form.help.alumnus',
            ])
            ->add('memberOf', OrganizationType::class, [
                'label' => 'form.field.member-of',
                'help' => 'form.help.member-of',
            ])
            ->add('nationality', CountryType::class, [
                'label' => 'form.field.nationality',
                'help' => 'form.help.nationality',
            ])
            ->add('facebook', FacebookType::class)
            ->add('instagram', InstagramType::class)
            ->add('linkedIn', LinkedInType::class)
            ->add('twitter', TwitterType::class)
            ->add('youtube', YoutubeType::class)
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
