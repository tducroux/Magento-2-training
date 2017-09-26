<?php
namespace SmileCoreTest;

/**
 * Rest client.
 *
 * @author    Guillaume Vrac <guvra@smile.fr>
 * @copyright 2016 Smile
 */
abstract class AbstractClient
{
    /**
     * Debug mode status.
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * the magento params
     *
     * @var array
     */
    protected $magentoParams;

    /**
     * Set the magento params
     *
     * @param array $params
     */
    public function setMagentoParams($params)
    {
        $this->magentoParams = $params;
    }

    /**
     * Check whether debug mode is enabled.
     *
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * Set debug mode status.
     *
     * @param bool $value
     * @return $this
     */
    public function setDebug($value)
    {
        $this->debug = (bool) $value;

        return $this;
    }
}
