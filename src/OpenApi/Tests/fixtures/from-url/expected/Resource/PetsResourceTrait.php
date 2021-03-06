<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Jane\OpenApi\Tests\Expected\Resource;

use Jane\OpenApiRuntime\Client\QueryParam;

trait PetsResourceTrait
{
    /**
     * @param array $parameters {
     *
     *     @var int $limit How many items to return at one time (max 100)
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Jane\OpenApi\Tests\Expected\Model\Pet|\Jane\OpenApi\Tests\Expected\Model\Error
     */
    public function listPets($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('limit', null);
        $url = '/v1/pets';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'petstore.swagger.io'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Pet[]', 'json');
            }

            return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Error', 'json');
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Jane\OpenApi\Tests\Expected\Model\Error
     */
    public function createPets($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/v1/pets';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'petstore.swagger.io'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (201 === $response->getStatusCode()) {
                return null;
            }

            return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Error', 'json');
        }

        return $response;
    }

    /**
     * @param string $petId      The id of the pet to retrieve
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Jane\OpenApi\Tests\Expected\Model\Pet|\Jane\OpenApi\Tests\Expected\Model\Error
     */
    public function showPetById($petId, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/v1/pets/{petId}';
        $url = str_replace('{petId}', urlencode($petId), $url);
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'petstore.swagger.io'], $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $response = $this->httpClient->sendRequest($request);
        if (self::FETCH_OBJECT === $fetch) {
            if (200 === $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Pet[]', 'json');
            }

            return $this->serializer->deserialize((string) $response->getBody(), 'Jane\\OpenApi\\Tests\\Expected\\Model\\Error', 'json');
        }

        return $response;
    }
}
