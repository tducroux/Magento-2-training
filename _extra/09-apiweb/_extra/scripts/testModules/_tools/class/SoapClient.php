<?php
namespace SmileCoreTest;

use \Zend\Soap\Client;

/**
 * Soap client.
 *
 * @author    Laurent Minguet <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class SoapClient extends AbstractClient
{
    /**
     * Soap Client
     *
     * @var Client
     */
    protected $client;

    /**
     * list of soap services
     *
     * @var string[]
     */
    protected $services = [];

    /**
     * add a service
     *
     * @param string $service
     */
    public function addService($service)
    {
        $this->services[] = $service;
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->initClient();
        }

        return $this->client;
    }

    /**
     * Init the client
     */
    protected function initClient()
    {
        // the WSDL URL of our Magento Site
        $wsdlUrl = $this->magentoParams['main_url'].'soap/?wsdl&services='.implode(',', $this->services);

        // the SOAP options
        $options = array(
            'soap_version' => SOAP_1_2,
            'features'     => SOAP_SINGLE_ELEMENT_ARRAYS,
            'stream_context' => stream_context_create(
                array(
                    'http' => array(
                        'header' => 'Authorization: Bearer '.$this->magentoParams['soap_token'],
                    )
                )
            )
        );

        if ($this->isDebug()) {
            echo "============================\n";
            echo sprintf("WSDL: [%s]\n", $wsdlUrl);
        }

        $this->client = new Client($wsdlUrl, $options);
    }

    /**
     * Magic call
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $client = $this->getClient();

        $name = (string) $name;

        if ($this->isDebug()) {
            echo "============================\n";
            echo sprintf("[%s] %s\n", $name, print_r($arguments, true));
        }

        $result = call_user_func_array([$client, (string)$name], $arguments)->result;

        if ($this->isDebug()) {
            print_r($result);
            echo "\n";
        }

        return $result;
    }
}
