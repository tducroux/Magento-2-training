<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Controller abstract
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractAction extends Action
{
    /**
     * @var Registry
     */
    protected $registry;

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
     * PHP Constructor
     *
     * @param Context                   $context
     * @param Registry                  $registry
     * @param SellerRepositoryInterface $sellerRepository
     * @param FilterBuilder             $filterBuilder
     * @param SortOrderBuilder          $sortOrderBuilder
     * @param SearchCriteriaBuilder     $searchCriteriaBuilder
     */
    public function __construct(
        Context                   $context,
        Registry                  $registry,
        SellerRepositoryInterface $sellerRepository,
        FilterBuilder             $filterBuilder,
        SortOrderBuilder          $sortOrderBuilder,
        SearchCriteriaBuilder     $searchCriteriaBuilder
    ) {
        $this->registry              = $registry;
        $this->sellerRepository      = $sellerRepository;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }
}
