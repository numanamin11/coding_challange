<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use BitBag\SyliusBannerPlugin\Entity\Banner as BaseBanner;

/**
 * @ORM\Entity
 * @ORM\Table(name="bitbag_banner")
 */
class ExtendedBanner extends BaseBanner
{
    /**
     * @ORM\ManyToMany(targetEntity="Sylius\Component\Taxonomy\Model\TaxonInterface")
     * @ORM\JoinTable(name="banner_taxons",
     *      joinColumns={@ORM\JoinColumn(name="banner_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="taxon_id", referencedColumnName="id")}
     * )
     */
    private $taxons;

    public function __construct()
    {
        parent::__construct();
        $this->taxons = new ArrayCollection();
    }

    /**
     * @return Collection|Taxon[]
     */
    public function getTaxons(): Collection
    {
        return $this->taxons;
    }

    public function addTaxon(Taxon $taxon): self
    {
        if (!$this->taxons->contains($taxon)) {
            $this->taxons[] = $taxon;
        }

        return $this;
    }

    public function removeTaxon(Taxon $taxon): self
    {
        if ($this->taxons->contains($taxon)) {
            $this->taxons->removeElement($taxon);
        }

        return $this;
    }
}
