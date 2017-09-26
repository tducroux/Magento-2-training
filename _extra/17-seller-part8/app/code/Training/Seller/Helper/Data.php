<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Catalog\Api\Data\ProductInterface;
use Training\Seller\Api\SellerRepositoryInterface;
use Training\Seller\Model\Seller;

/**
 * Helper: Data
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Data extends AbstractHelper
{
    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * PHP constructor
     *
     * @param Context                   $context
     * @param SellerRepositoryInterface $sellerRepository
     * @param FilterBuilder             $filterBuilder
     * @param SortOrderBuilder          $sortOrderBuilder
     * @param SearchCriteriaBuilder     $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        SellerRepositoryInterface $sellerRepository,
        FilterBuilder             $filterBuilder,
        SortOrderBuilder          $sortOrderBuilder,
        SearchCriteriaBuilder     $searchCriteriaBuilder
    ) {
        $this->sellerRepository      = $sellerRepository;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }

    /**
     * Get the list of the sellerIds of a product
     *
     * @param ProductInterface $product
     *
     * @return int[]
     */
    public function getProductSellerIds(ProductInterface $product)
    {
        $sellerIds = $product->getTrainingSellerIds();
        if (!is_array($sellerIds)) {
            $sellerIds = explode(',', $sellerIds);
        }

        foreach ($sellerIds as $key => $value) {
            $sellerIds[$key] = (int) $value;
        }

        return $sellerIds;
    }

    /**
     * Build a search criteria with filter on seller ids
     *
     * @param int[] $sellerIds
     *
     * @return SearchCriteria
     */
    public function getSearchCriteriaOnSellerIds($sellerIds)
    {
        // filter on seller ids
        $filters = [];
        $filters[] = $this->filterBuilder
            ->setField(Seller::FIELD_SELLER_ID)
            ->setConditionType('in')
            ->setValue($sellerIds)
            ->create();
        $this->searchCriteriaBuilder->addFilters($filters);

        // sort by name
        $sort = $this->sortOrderBuilder
            ->setField(Seller::FIELD_NAME)
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sort);

        // build the criteria
        return $this->searchCriteriaBuilder->create();
    }


    /**
     * Get the sellers linked to a product
     *
     * @param ProductInterface $product
     *
     * @return Seller[]
     */
    public function getProductSellers(ProductInterface $product)
    {
        $sellerIds = $this->getProductSellerIds($product);
        $searchCriteria = $this->getSearchCriteriaOnSellerIds($sellerIds);
        return $this->sellerRepository->getList($searchCriteria)->getItems();
    }
}
