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

use App\Entity\Organization;
use App\Entity\Person;
use App\Entity\Service;
use App\Form\Type\BirthNameType;
use App\Form\Type\CategoryType;
use App\Form\Type\CountryType;
use App\Form\Type\FacebookType;
use App\Form\Type\FamilyNameType;
use App\Form\Type\GenderType;
use App\Form\Type\GivenNameType;
use App\Form\Type\InstagramType;
use App\Form\Type\JobTitleType;
use App\Form\Type\LinkedInType;
use App\Form\Type\OrganizationType;
use App\Form\Type\ServiceType;
use App\Form\Type\TelephoneType;
use App\Form\Type\TwitterType;
use App\Form\Type\UrlType;
use App\Form\Type\YoutubeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Person form class.
 */
class PersonForm extends AbstractType
{
    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PersonForm constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
            ->add('category', CategoryType::class)
            ->add('jobTitle', JobTitleType::class)
            ->add('email', EmailType::class, [
                'label' => 'form.field.email',
                'help' => 'form.help.email',
                'required' => false,
            ])
            ->add('gender', GenderType::class)
            ->add('smartphone', TelephoneType::class, [
                'label' => 'form.field.smartphone',
                'help' => 'form.help.smartphone',
                'icon' => 'mobile-alt',
            ])
            ->add('telephone', TelephoneType::class)
            ->add('url', UrlType::class)
            ->add('address', PostalAddressForm::class, [
                'label' => 'form.person.field.address',
            ])
            ->add('alumnus', OrganizationType::class, [
                'label' => 'form.field.alumnus',
                'help' => 'form.help.alumnus',
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

        // 3. Add 2 event listeners for the form
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
    }

    protected function addElements(FormInterface $form, Organization $organization = null)
    {
        $form->add('memberOf', OrganizationType::class, [
            'required' => true,
            'data' => $organization,
        ]);

        // Services empty, unless there is a selected City (Edit View)
        $services = [];

        // If there is a city stored in the Person entity, load the services of it
        if ($organization) {
            // Fetch Services of the City if there's a selected city
            $serviceRepository = $this->entityManager->getRepository(Service::class);

            $services = $serviceRepository->createQueryBuilder('s')
                ->where('s.organization = :organization')
                ->orderBy('s.name')
                ->setParameter('organization', $organization)
                ->getQuery()
                ->getResult();
        }

        // Add the Services field with the properly data
        $form->add('service', ServiceType::class, array(
            'choices' => $services,
        ));
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected City and convert it into an Entity
        $organization = $this->entityManager->getRepository(Organization::class)->find($data['memberOf']);

        $this->addElements($form, $organization);
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        /** @var Person $person */
        $person = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the Organization is always empty
        $organization = $person->getMemberOf() ? $person->getMemberOf() : null;

        $this->addElements($form, $organization);
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

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'app_person';
    }
}
