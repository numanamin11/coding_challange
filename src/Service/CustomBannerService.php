<?php 
namespace App\Service;

use Doctrine\DBAL\Connection;

class CustomBannerService
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Finds banners linked to a specific taxon slug.
     *
     * @param string $slug The slug of the taxon.
     * @return array An array of banners associated with the taxon.
     */
    public function findBannersByTaxonSlug(string $slug,string $locale): array
    {
        $sql = "
            SELECT b.*
                FROM bitbag_banner b
                INNER JOIN banner_taxons bt ON b.id = bt.banner_id
                INNER JOIN sylius_taxon t ON bt.taxon_id = t.id
                INNER JOIN sylius_taxon_translation stt ON t.id = stt.translatable_id
                WHERE stt.slug = :slug
                AND stt.locale = :locale
        ";
        $result = $this->connection->executeQuery($sql, ['slug' => $slug,'locale' => $locale]);

        return $result->fetchAllAssociative();
    }

}
