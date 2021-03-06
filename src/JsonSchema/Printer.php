<?php

namespace Jane\JsonSchema;

use PhpCsFixer\Cache\NullCacheManager;
use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Console\ConfigurationResolver;
use PhpCsFixer\Differ\NullDiffer;
use PhpCsFixer\Error\ErrorsManager;
use PhpCsFixer\Finder;
use PhpCsFixer\Linter\Linter;
use PhpCsFixer\Runner\Runner;
use PhpCsFixer\ToolInfo;
use PhpParser\PrettyPrinterAbstract;

class Printer
{
    private $prettyPrinter;

    private $fixerConfig;

    public function __construct(PrettyPrinterAbstract $prettyPrinter, ConfigInterface $fixerConfig = null)
    {
        $this->prettyPrinter = $prettyPrinter;
        $this->fixerConfig = $fixerConfig;
    }

    public function output(Registry $registry): void
    {
        foreach ($registry->getSchemas() as $schema) {
            foreach ($schema->getFiles() as $file) {
                if (!file_exists(dirname($file->getFilename()))) {
                    mkdir(dirname($file->getFilename()), 0755, true);
                }

                file_put_contents($file->getFilename(), $this->prettyPrinter->prettyPrintFile([$file->getNode()]));
            }
        }

        foreach ($registry->getSchemas() as $schema) {
            $this->fix($schema->getDirectory());
        }
    }

    protected function fix(string $directory): void
    {
        if (!class_exists('PhpCsFixer\Config')) {
            return;
        }

        /** @var Config $fixerConfig */
        $fixerConfig = $this->fixerConfig;

        if (null === $fixerConfig) {
            $fixerConfig = Config::create()
                ->setRiskyAllowed(true)
                ->setRules(
                    [
                        '@Symfony' => true,
                        'array_syntax' => ['syntax' => 'short'],
                        'concat_space' => false,
                        'yoda_style' => null,
                        'declare_strict_types' => true,
                        'header_comment' => [
                            'header' => <<<EOH
This file has been auto generated by Jane,

Do no edit it directly.
EOH
                            ,
                        ],
                    ]
                );
        }
        $resolverOptions = ['allow-risky' => true];
        $resolver = new ConfigurationResolver($fixerConfig, $resolverOptions, $directory, new ToolInfo());

        $finder = new Finder();
        $finder->in($directory);

        $fixerConfig->setFinder($finder);

        $runner = new Runner(
            $resolver->getConfig()->getFinder(),
            $resolver->getFixers(),
            new NullDiffer(),
            null,
            new ErrorsManager(),
            new Linter(),
            false,
            new NullCacheManager()
        );

        $runner->fix();
    }
}