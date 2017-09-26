<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;

/**
 * Shop Controller, action Products
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Search extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * PHP Constructor
     *
     * @param \Magento\Framework\App\Action\Context           $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder    $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder            $filterBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder         $sortOrderBuilder
     */
    public function __construct(
        \Magento\Framework\App\Action\Context           $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder    $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder            $filterBuilder,
        \Magento\Framework\Api\SortOrderBuilder         $sortOrderBuilder
    ) {
        parent::__construct($context);

        $this->productRepository     = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        $products = $this->getProductList();

        foreach ($products as $product) {
            $this->outputProduct($product);
        }
    }

    /**
     * get the list of the products to display
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    protected function getProductList()
    {
        $filterDesc[] = $this->filterBuilder
            ->setField('description')
            ->setConditionType('like')
            ->setValue('%comfortable%')
            ->create();

        $filterName[] = $this->filterBuilder
            ->setField('name')
            ->setConditionType('like')
            ->setValue('%Bruno%')
            ->create();

        $sortOrder = $this->sortOrderBuilder
            ->setField('name')
            ->setDescendingDirection()
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filterDesc)
            ->addFilters($filterName)
            ->addSortOrder($sortOrder)
            ->setPageSize(6)
            ->setCurrentPage(1)
            ->create();

        return $this->productRepository
            ->getList($searchCriteria)
            ->getItems();
    }

    /**
     * output a product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return void
     */
    protected function outputProduct(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $this->getResponse()->appendBody(
            $product->getSku().' => '.$product->getName().'<br />'
        );
    }
}
