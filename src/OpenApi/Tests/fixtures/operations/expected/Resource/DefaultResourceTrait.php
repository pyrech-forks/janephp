<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Jane\OpenApi\Tests\Expected\Resource;

use Jane\OpenApiRuntime\Client\QueryParam;

trait DefaultResourceTrait
{
    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function testNoTag($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/test-no-tag';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return null;
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getTestOperationUrl($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/test-operation-url';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return null;
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getTestOperationUrlById($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/test-operation-url/{id}';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return null;
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getTestOperationUrlWithExtension($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/test-operation-url-with-extension.php';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return null;
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Jane\OpenApi\Tests\Expected\Model\Thing
     */
    public function getThings($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/things';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Thing[]', 'json');
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Jane\OpenApi\Tests\Expected\Model\Thing
     */
    public function getThingsById($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/things/{id}';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Thing[]', 'json');
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Jane\OpenApi\Tests\Expected\Model\Thing
     */
    public function getAnotherThing($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/another-things';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Thing', 'json');
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Jane\OpenApi\Tests\Expected\Model\Thing
     */
    public function getAnotherThingById($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/another-things/{id}';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Thing', 'json');
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function postNo200Thing($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/no-200-things';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (204 === $response->getStatusCode()) {
                return null;
            }
        }

        return $response;
    }
}
