<?php 

namespace App\Form\Type;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use BitBag\SyliusBannerPlugin\Form\Type\BannerType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Taxonomy\Taxon;

class BannerTypeTaxon extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [BannerType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

         $builder->add('taxons', EntityType::class, [
            'class' => Taxon::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => false,
            'required' => false,
            'label' => 'sylius.form.product.taxons',
        ]);

    }
}
