<?php

namespace Jane\OpenApi;

use Jane\JsonSchema\Generator\Context\Context;
use Jane\JsonSchema\Generator\File;
use Jane\JsonSchema\Generator\ModelGenerator;
use Jane\JsonSchema\Generator\Naming;
use Jane\JsonSchema\Generator\NormalizerGenerator;
use Jane\JsonSchema\Guesser\ChainGuesser;
use Jane\OpenApi\Generator\ClientGenerator;
use Jane\OpenApi\Generator\GeneratorFactory;
use Jane\OpenApi\Guesser\OpenApiSchema\GuesserFactory;
use Jane\OpenApi\Model\OpenApi;
use Jane\OpenApi\Normalizer\NormalizerFactory;
use Jane\OpenApi\SchemaParser\SchemaParser;
use Jane\JsonSchema\Registry;
use Jane\JsonSchema\Schema;
use PhpCsFixer\ConfigInterface;
use PhpParser\PrettyPrinterAbstract;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class JaneOpenApi
{
    const VERSION = '4.x-dev';

    /**
     * @var SchemaParser
     */
    private $schemaParser;
    /**
     * @var Generator\ClientGenerator
     */
    private $clientGenerator;

    /**
     * @var ModelGenerator
     */
    private $modelGenerator;

    /**
     * @var NormalizerGenerator
     */
    private $normalizerGenerator;

    /**
     * @var ChainGuesser
     */
    private $chainGuesser;

    private $strict;

    public function __construct(
        SchemaParser $schemaParser,
        ChainGuesser $chainGuesser,
        ModelGenerator $modelGenerator,
        NormalizerGenerator $normalizerGenerator,
        ClientGenerator $clientGenerator,
        bool $strict = true
    ) {
        $this->schemaParser = $schemaParser;
        $this->clientGenerator = $clientGenerator;
        $this->modelGenerator = $modelGenerator;
        $this->normalizerGenerator = $normalizerGenerator;
        $this->chainGuesser = $chainGuesser;
        $this->strict = $strict;
    }

    /**
     * Return a list of class guessed.
     *
     * @param Registry $registry A registry
     *
     * @return Context
     */
    public function createContext(Registry $registry)
    {
        $schemas = array_values($registry->getSchemas());

        /** @var Schema $schema */
        foreach ($schemas as $schema) {
            $openApiSpec = $this->schemaParser->parseSchema($schema->getOrigin());
            $this->chainGuesser->guessClass($openApiSpec, $schema->getRootName(), $schema->getOrigin() . '#', $registry);
            $schema->setParsed($openApiSpec);
        }

        foreach ($registry->getSchemas() as $schema) {
            foreach ($schema->getClasses() as $class) {
                $properties = $this->chainGuesser->guessProperties($class->getObject(), $schema->getRootName(), $class->getReference(), $registry);

                foreach ($properties as $property) {
                    $property->setType($this->chainGuesser->guessType($property->getObject(), $property->getName(), $property->getReference(), $registry));
                }

                $class->setProperties($properties);
            }
        }

        return new Context($registry, $this->strict);
    }

    /**
     * Generate a list of files.
     *
     * @param Registry $registry A registry
     *
     * @return File[]
     */
    public function generate(Registry $registry)
    {
        /** @var OpenApi $openApi */
        $context = $this->createContext($registry);

        $files = [];

        foreach ($registry->getSchemas() as $schema) {
            $context->setCurrentSchema($schema);

            $this->modelGenerator->generate($schema, $schema->getRootName(), $context);
            $this->normalizerGenerator->generate($schema, $schema->getRootName(), $context);

            $clients = $this->clientGenerator->generate($schema->getParsed(), $schema->getNamespace(), $context, $schema->getOrigin() . '#');

            foreach ($clients['resources'] as $node) {
                $class = $node['class'];
                $trait = $node['trait'];
                $name = $node['name'];

                $schema->addFile(new File($schema->getDirectory() . DIRECTORY_SEPARATOR . 'Resource' . DIRECTORY_SEPARATOR . $name . '.php', $class, ''));
                $schema->addFile(new File($schema->getDirectory() . DIRECTORY_SEPARATOR . 'Resource' . DIRECTORY_SEPARATOR . $name . 'Trait.php', $trait, ''));
            }

            $schema->addFile(new File($schema->getDirectory(). DIRECTORY_SEPARATOR . 'Client.php', $clients['client'], ''));
        }

        return $files;
    }

    public static function build(array $options = [])
    {
        $encoders = [
            new JsonEncoder(
                new JsonEncode(),
                new JsonDecode(false)
            ),
            new YamlEncoder(
                new Dumper(),
                new Parser()
            ),
        ];
        $normalizers = NormalizerFactory::create();
        $serializer = new Serializer($normalizers, $encoders);
        $schemaParser = new SchemaParser($serializer);
        $clientGenerator = GeneratorFactory::build($serializer, $options);
        $naming = new Naming();
        $modelGenerator = new ModelGenerator($naming);
        $normGenerator = new NormalizerGenerator($naming, $options['reference'] ?? false);

        return new self(
            $schemaParser,
            GuesserFactory::create($serializer, $options),
            $modelGenerator,
            $normGenerator,
            $clientGenerator,
            $options['strict'] ?? true
        );
    }
}
