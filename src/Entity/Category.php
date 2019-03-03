<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category resource entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(
 *     name="tr_categorie", schema="data", options={"comment":"Category table"},
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="ul_category_label", columns={"cat_label"})
 *     }
 * )
 */
class Category
{
    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="cat_id", options={"comment":"Category identifier"})
     */
    private $id;

    /**
     * Label.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=32, name="cat_label")
     */
    private $label;

    /**
     * People of this category.
     *
     * @var Person[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="category")
     */
    private $people;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->people = new ArrayCollection();
    }

    /**
     * Identifier getter.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Label getter.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Label fluent setter.
     *
     * @param string $label
     *
     * @return Category
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    /**
     * Add a person to this category.
     *
     * @param Person $person
     *
     * @return Category
     */
    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setCategory($this);
        }

        return $this;
    }

    /**
     * Remove person.
     *
     * @param Person $person
     *
     * @return Category
     */
    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getCategory() === $this) {
                $person->setCategory(null);
            }
        }

        return $this;
    }
}
