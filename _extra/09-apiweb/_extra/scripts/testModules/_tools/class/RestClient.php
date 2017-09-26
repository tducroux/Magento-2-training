<?php
namespace SmileCoreTest;

use Zend\Http\Client;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Rest client.
 *
 * @author    Guillaume Vrac <guvra@smile.fr>
 * @copyright 2016 Smile
 */
class RestClient extends AbstractClient
{
    /**
     * Zend client.
     *
     * @var \Zend\Http\Client
     */
    protected $client;

    /**
     * Authentication token.
     *
     * @var string
     */
    protected $token;

    /**
     * Constructor.
     *
     * @params array $options
     */
    public function __construct(array $options = [])
    {
        $options += [
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
            'maxredirects' => 0,
            'timeout' => 30
        ];

        $this->client = new Client();
        $this->client->setOptions($options);
    }

    /**
     * connect the magento user
     *
     * @return void
     */
    public function connect()
    {
        $result = $this->post('rest/V1/integration/admin/token', $this->magentoParams['rest_account']);
        $this->token = $result;
    }

    /**
     * Get the authentication token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the authentication token.
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = (string) $token;

        return $this;
    }

    /**
     * Send a HTTP request using the GET method.
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return string
     */
    public function get($url, array $params = [], array $headers = [])
    {
        $method = Request::METHOD_GET;

        return $this->call($url, $method, $params, $headers);
    }

    /**
     * Send a HTTP request using the PUT method.
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return string
     */
    public function put($url, array $params = [], array $headers = [])
    {
        $method = Request::METHOD_PUT;

        return $this->call($url, $method, $params, $headers);
    }

    /**
     * Send a HTTP request using the POST method.
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return string
     */
    public function post($url, array $params = [], array $headers = [])
    {
        $method = Request::METHOD_POST;

        return $this->call($url, $method, $params, $headers);
    }

    /**
     * Send a HTTP request using the DELETE method.
     *
     * @param string $url
     * @param array $headers
     * @return string
     */
    public function delete($url, array $headers = [])
    {
        $method = Request::METHOD_DELETE;

        return $this->call($url, $method, [], $headers);
    }

    /**
     * Send a HTTP request.
     *
     * @param string $url
     * @param string $method
     * @param array $params
     * @param array $headers
     * @return string
     */
    protected function call($url, $method, array $params = [], array $headers = [])
    {
        if (substr($url, 0, 7) !== 'http://' && substr($url, 0, 8) !== 'https://') {
            $url = $this->magentoParams['main_url'].$url;
        }

        if ($this->isDebug()) {
            echo "============================\n";
            echo sprintf("[%s] %s\n", $method, $url);
        }

        // Set the headers
        $headers = $this->buildHeaders($headers);
        $httpHeaders = new Headers();
        $httpHeaders->addHeaders($headers);

        // Initialize the request
        $request = new Request();
        $request->setHeaders($httpHeaders);
        $request->setUri($url);
        $request->setMethod($method);

        // Set the query params
        $params = new Parameters($params);
        $request->setQuery($params);

        // Send the request
        $response = $this->client->send($request);

        $body = json_decode($response->getBody(), true);

        if ($this->isDebug()) {
            print_r($body);
            echo "\n";
        }

        if (is_array($body) && !empty($body['trace']) && $this->magentoParams['exception_on_error']) {
            throw new \Exception('Rest ERROR: '.$body['trace']);
        }

        return $body;
    }

    /**
     * Build the HTTP headers.
     *
     * @param array $headers
     * @return array
     */
    protected function buildHeaders(array $headers)
    {
        $headers += [
           'Accept' => 'application/json',
           'Content-Type' => 'application/json'
        ];

        $token = $this->getToken();
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }
}
