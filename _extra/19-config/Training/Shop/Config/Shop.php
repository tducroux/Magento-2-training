<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Config;

use Magento\Framework\Config\Data as ConfigData;
use \Magento\Framework\Config\CacheInterface;
use Training\Shop\Api\Config\ShopInterface;
use Training\Shop\Config\Shop\Reader as ShopReader;

/**
 * Class Config Access: Shop
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Shop extends ConfigData implements ShopInterface
{
    /**
     * PHP Constructor with DI
     *
     * @param ShopReader     $reader
     * @param CacheInterface $cache
     * @param string         $cacheId
     */
    public function __construct(
        ShopReader      $reader,
        CacheInterface  $cache,
        $cacheId = 'training_shop_config'
    ) {
        parent::__construct($reader, $cache, $cacheId);
    }

    /**
     * Get a shop by its code
     *
     * @param string $code code to get
     *
     * @return array
     */
    public function getShop($code)
    {
        return $this->get($code, []);
    }

    /**
     * Get all registered shops
     *
     * @return array
     */
    public function getShops()
    {
        return $this->get();
    }
}
