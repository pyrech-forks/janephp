<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Jane\OpenApi\Normalizer;

use Jane\JsonSchemaRuntime\Reference;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OperationNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    public function supportsDenormalization($data, $type, $format = null)
    {
        if ('Jane\\OpenApi\\Model\\Operation' !== $type) {
            return false;
        }

        return true;
    }

    public function supportsNormalization($data, $format = null)
    {
        if ($data instanceof \Jane\OpenApi\Model\Operation) {
            return true;
        }

        return false;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException();
        }
        if (isset($data->{'$ref'})) {
            return new Reference($data->{'$ref'}, $context['document-origin']);
        }
        $object = new \Jane\OpenApi\Model\Operation();
        if (property_exists($data, 'tags')) {
            $values = [];
            foreach ($data->{'tags'} as $value) {
                $values[] = $value;
            }
            $object->setTags($values);
        }
        if (property_exists($data, 'summary')) {
            $object->setSummary($data->{'summary'});
        }
        if (property_exists($data, 'description')) {
            $object->setDescription($data->{'description'});
        }
        if (property_exists($data, 'externalDocs')) {
            $object->setExternalDocs($this->denormalizer->denormalize($data->{'externalDocs'}, 'Jane\\OpenApi\\Model\\ExternalDocs', 'json', $context));
        }
        if (property_exists($data, 'operationId')) {
            $object->setOperationId($data->{'operationId'});
        }
        if (property_exists($data, 'produces')) {
            $values_1 = [];
            foreach ($data->{'produces'} as $value_1) {
                $values_1[] = $value_1;
            }
            $object->setProduces($values_1);
        }
        if (property_exists($data, 'consumes')) {
            $values_2 = [];
            foreach ($data->{'consumes'} as $value_2) {
                $values_2[] = $value_2;
            }
            $object->setConsumes($values_2);
        }
        if (property_exists($data, 'parameters')) {
            $values_3 = [];
            foreach ($data->{'parameters'} as $value_3) {
                $value_4 = $value_3;
                if (is_object($value_3) and isset($value_3->{'name'}) and (isset($value_3->{'in'}) and 'body' == $value_3->{'in'}) and isset($value_3->{'schema'})) {
                    $value_4 = $this->denormalizer->denormalize($value_3, 'Jane\\OpenApi\\Model\\BodyParameter', 'json', $context);
                }
                if (is_object($value_3) and (isset($value_3->{'in'}) and 'header' == $value_3->{'in'}) and isset($value_3->{'name'}) and (isset($value_3->{'type'}) and ('string' == $value_3->{'type'} or 'number' == $value_3->{'type'} or 'boolean' == $value_3->{'type'} or 'integer' == $value_3->{'type'} or 'array' == $value_3->{'type'}))) {
                    $value_4 = $this->denormalizer->denormalize($value_3, 'Jane\\OpenApi\\Model\\HeaderParameterSubSchema', 'json', $context);
                }
                if (is_object($value_3) and (isset($value_3->{'in'}) and 'formData' == $value_3->{'in'}) and isset($value_3->{'name'}) and (isset($value_3->{'type'}) and ('string' == $value_3->{'type'} or 'number' == $value_3->{'type'} or 'boolean' == $value_3->{'type'} or 'integer' == $value_3->{'type'} or 'array' == $value_3->{'type'} or 'file' == $value_3->{'type'}))) {
                    $value_4 = $this->denormalizer->denormalize($value_3, 'Jane\\OpenApi\\Model\\FormDataParameterSubSchema', 'json', $context);
                }
                if (is_object($value_3) and (isset($value_3->{'in'}) and 'query' == $value_3->{'in'}) and isset($value_3->{'name'}) and (isset($value_3->{'type'}) and ('string' == $value_3->{'type'} or 'number' == $value_3->{'type'} or 'boolean' == $value_3->{'type'} or 'integer' == $value_3->{'type'} or 'array' == $value_3->{'type'}))) {
                    $value_4 = $this->denormalizer->denormalize($value_3, 'Jane\\OpenApi\\Model\\QueryParameterSubSchema', 'json', $context);
                }
                if (is_object($value_3) and (isset($value_3->{'required'}) and '1' == $value_3->{'required'}) and (isset($value_3->{'in'}) and 'path' == $value_3->{'in'}) and isset($value_3->{'name'}) and (isset($value_3->{'type'}) and ('string' == $value_3->{'type'} or 'number' == $value_3->{'type'} or 'boolean' == $value_3->{'type'} or 'integer' == $value_3->{'type'} or 'array' == $value_3->{'type'}))) {
                    $value_4 = $this->denormalizer->denormalize($value_3, 'Jane\\OpenApi\\Model\\PathParameterSubSchema', 'json', $context);
                }
                if (is_object($value_3) and isset($value_3->{'$ref'})) {
                    $value_4 = $this->denormalizer->denormalize($value_3, 'Jane\\OpenApi\\Model\\JsonReference', 'json', $context);
                }
                $values_3[] = $value_4;
            }
            $object->setParameters($values_3);
        }
        if (property_exists($data, 'responses')) {
            $values_4 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data->{'responses'} as $key => $value_5) {
                if (preg_match('/^([0-9]{3})$|^(default)$/', $key) && isset($value_5)) {
                    $value_6 = $value_5;
                    if (is_object($value_5) and isset($value_5->{'description'})) {
                        $value_6 = $this->denormalizer->denormalize($value_5, 'Jane\\OpenApi\\Model\\Response', 'json', $context);
                    }
                    if (is_object($value_5) and isset($value_5->{'$ref'})) {
                        $value_6 = $this->denormalizer->denormalize($value_5, 'Jane\\OpenApi\\Model\\JsonReference', 'json', $context);
                    }
                    $values_4[$key] = $value_6;
                    continue;
                }
                if (preg_match('/^x-/', $key) && isset($value_5)) {
                    $values_4[$key] = $value_5;
                    continue;
                }
            }
            $object->setResponses($values_4);
        }
        if (property_exists($data, 'schemes')) {
            $values_5 = [];
            foreach ($data->{'schemes'} as $value_7) {
                $values_5[] = $value_7;
            }
            $object->setSchemes($values_5);
        }
        if (property_exists($data, 'deprecated')) {
            $object->setDeprecated($data->{'deprecated'});
        }
        if (property_exists($data, 'security')) {
            $values_6 = [];
            foreach ($data->{'security'} as $value_8) {
                $values_7 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
                foreach ($value_8 as $key_1 => $value_9) {
                    $values_8 = [];
                    foreach ($value_9 as $value_10) {
                        $values_8[] = $value_10;
                    }
                    $values_7[$key_1] = $values_8;
                }
                $values_6[] = $values_7;
            }
            $object->setSecurity($values_6);
        }

        return $object;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = new \stdClass();
        if (null !== $object->getTags()) {
            $values = [];
            foreach ($object->getTags() as $value) {
                $values[] = $value;
            }
            $data->{'tags'} = $values;
        }
        if (null !== $object->getSummary()) {
            $data->{'summary'} = $object->getSummary();
        }
        if (null !== $object->getDescription()) {
            $data->{'description'} = $object->getDescription();
        }
        if (null !== $object->getExternalDocs()) {
            $data->{'externalDocs'} = $this->normalizer->normalize($object->getExternalDocs(), 'json', $context);
        }
        if (null !== $object->getOperationId()) {
            $data->{'operationId'} = $object->getOperationId();
        }
        if (null !== $object->getProduces()) {
            $values_1 = [];
            foreach ($object->getProduces() as $value_1) {
                $values_1[] = $value_1;
            }
            $data->{'produces'} = $values_1;
        }
        if (null !== $object->getConsumes()) {
            $values_2 = [];
            foreach ($object->getConsumes() as $value_2) {
                $values_2[] = $value_2;
            }
            $data->{'consumes'} = $values_2;
        }
        if (null !== $object->getParameters()) {
            $values_3 = [];
            foreach ($object->getParameters() as $value_3) {
                $value_4 = $value_3;
                if (is_object($value_3)) {
                    $value_4 = $this->normalizer->normalize($value_3, 'json', $context);
                }
                if (is_object($value_3)) {
                    $value_4 = $this->normalizer->normalize($value_3, 'json', $context);
                }
                if (is_object($value_3)) {
                    $value_4 = $this->normalizer->normalize($value_3, 'json', $context);
                }
                if (is_object($value_3)) {
                    $value_4 = $this->normalizer->normalize($value_3, 'json', $context);
                }
                if (is_object($value_3)) {
                    $value_4 = $this->normalizer->normalize($value_3, 'json', $context);
                }
                if (is_object($value_3)) {
                    $value_4 = $this->normalizer->normalize($value_3, 'json', $context);
                }
                $values_3[] = $value_4;
            }
            $data->{'parameters'} = $values_3;
        }
        if (null !== $object->getResponses()) {
            $values_4 = new \stdClass();
            foreach ($object->getResponses() as $key => $value_5) {
                if (preg_match('/^([0-9]{3})$|^(default)$/', $key) && null !== $value_5) {
                    $value_6 = $value_5;
                    if (is_object($value_5)) {
                        $value_6 = $this->normalizer->normalize($value_5, 'json', $context);
                    }
                    if (is_object($value_5)) {
                        $value_6 = $this->normalizer->normalize($value_5, 'json', $context);
                    }
                    $values_4->{$key} = $value_6;
                    continue;
                }
                if (preg_match('/^x-/', $key) && null !== $value_5) {
                    $values_4->{$key} = $value_5;
                    continue;
                }
            }
            $data->{'responses'} = $values_4;
        }
        if (null !== $object->getSchemes()) {
            $values_5 = [];
            foreach ($object->getSchemes() as $value_7) {
                $values_5[] = $value_7;
            }
            $data->{'schemes'} = $values_5;
        }
        if (null !== $object->getDeprecated()) {
            $data->{'deprecated'} = $object->getDeprecated();
        }
        if (null !== $object->getSecurity()) {
            $values_6 = [];
            foreach ($object->getSecurity() as $value_8) {
                $values_7 = new \stdClass();
                foreach ($value_8 as $key_1 => $value_9) {
                    $values_8 = [];
                    foreach ($value_9 as $value_10) {
                        $values_8[] = $value_10;
                    }
                    $values_7->{$key_1} = $values_8;
                }
                $values_6[] = $values_7;
            }
            $data->{'security'} = $values_6;
        }

        return $data;
    }
}
