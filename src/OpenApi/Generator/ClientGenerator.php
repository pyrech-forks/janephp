<?php

namespace Jane\OpenApi\Generator;

use Jane\JsonSchema\Generator\Context\Context;
use Jane\OpenApi\Model\OpenApi;
use Jane\OpenApi\Naming\OperationNamingInterface;
use Jane\OpenApi\Operation\OperationManager;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt;

class ClientGenerator
{
    /**
     * @var \Jane\OpenApi\Operation\OperationManager
     */
    private $operationManager;

    /**
     * @var OperationGenerator
     */
    private $operationGenerator;

    /**
     * @var OperationNamingInterface
     */
    private $operationNaming;

    private $generateAsync;

    public function __construct(OperationManager $operationManager, OperationGenerator $operationGenerator, OperationNamingInterface $operationNaming, bool $generateAsync = false)
    {
        $this->operationManager = $operationManager;
        $this->operationGenerator = $operationGenerator;
        $this->operationNaming = $operationNaming;
        $this->generateAsync = $generateAsync;
    }

    /**
     * Generate an ast node (which correspond to a class) for a OpenApi spec.
     *
     * @param OpenApi $openApi
     * @param string  $namespace
     * @param Context $context
     * @param string  $reference
     * @param string  $suffix
     *
     * @return Node[]
     */
    public function generate(OpenApi $openApi, string $namespace, Context $context, string $reference, string $suffix = 'Resource')
    {
        $factory = new BuilderFactory();
        $classClient = $factory->class('Client');
        $classClient->extend('Resource');

        $classCreator = $factory->namespace($namespace)
            ->addStmt($factory->use('Jane\OpenApiRuntime\Client\Resource'))
        ;

        $nodes = [];
        $operationsGrouped = $this->operationManager->buildOperationCollection($openApi, $reference);

        foreach ($operationsGrouped as $group => $operations) {
            $resource = $this->generateClass($group, $operations, $namespace, $context, $suffix);
            $classClient->addStmt(new Stmt\TraitUse([
                new Node\Name($group . $suffix . 'Trait'),
            ]));
            $classCreator->addStmt($factory->use($namespace . '\\Resource\\' . $group . $suffix . 'Trait'));

            $nodes[] = $resource;
        }

        $classClient->addStmt(new Stmt\ClassMethod(
            'create', [
                'flags' => Stmt\Class_::MODIFIER_STATIC | Stmt\Class_::MODIFIER_PUBLIC,
                'params' => [
                    new Node\Param('httpClient', new Expr\ConstFetch(new Name('null')))
                ],
                'stmts' => [
                    new Stmt\If_(
                        new Expr\BinaryOp\Identical(new Expr\ConstFetch(new Name('null')), new Expr\Variable('httpClient')),
                        [
                            'stmts' => [
                                new Stmt\TryCatch([
                                    new Expr\Assign(
                                        new Expr\Variable('httpClient'),
                                        new Expr\StaticCall(
                                            new Name('\\Http\\Discovery\\HttpAsyncClientDiscovery'),
                                            'find'
                                        )
                                    )
                                ], [
                                    new Stmt\Catch_([
                                        new Name('\\Http\\Discovery\\NotFoundException')
                                    ], 'e', [
                                        new Expr\Assign(
                                            new Expr\Variable('httpClient'),
                                            new Expr\StaticCall(
                                                new Name('\\Http\\Discovery\\HttpClientDiscovery'),
                                                'find'
                                            )
                                        )
                                    ])
                                ])
                            ]
                        ]
                    ),
                    new Expr\Assign(
                        new Expr\Variable('messageFactory'),
                        new Expr\StaticCall(
                            new Name('\\Http\\Discovery\\MessageFactoryDiscovery'),
                            'find'
                        )
                    ),
                    new Expr\Assign(
                        new Expr\Variable('serializer'),
                        new Expr\New_(
                            new Name('\\Symfony\\Component\\Serializer\\Serializer'),
                            [
                                new Node\Arg(
                                    new Expr\StaticCall(
                                        new Name('\\' . $context->getCurrentSchema()->getNamespace() . '\\Normalizer\\NormalizerFactory'),
                                        'create'
                                    )
                                ),
                                new Node\Arg(
                                    new Expr\Array_([
                                        new Expr\ArrayItem(
                                            new Expr\New_(new Name('\\Symfony\\Component\\Serializer\\Encoder\\JsonEncoder'), [
                                                new Node\Arg(new Expr\New_(new Name('\\Symfony\\Component\\Serializer\\Encoder\\JsonEncode'))),
                                                new Node\Arg(new Expr\New_(new Name('\\Symfony\\Component\\Serializer\\Encoder\\JsonDecode'))),
                                            ])
                                        )
                                    ])
                                )
                            ]
                        )
                    ),
                    new Stmt\Return_(
                        new Expr\New_(
                            new Name('self'), [
                                new Node\Arg(new Expr\Variable('httpClient')),
                                new Node\Arg(new Expr\Variable('messageFactory')),
                                new Node\Arg(new Expr\Variable('serializer')),
                            ]
                        )
                    ),
                ]
            ]
        ));

        $classCreator->addStmt($classClient);

        return [
            'resources' => $nodes,
            'client' => $classCreator->getNode()
        ];
    }

    protected function generateClass($group, $operations, $namespace, Context $context, $suffix = 'Resource')
    {
        $factory = new BuilderFactory();
        $trait = $factory->trait($group . $suffix . 'Trait');
        $class = $factory->class($group . $suffix);
        $class->extend('Resource');

        foreach ($operations as $operation) {
            $trait->addStmt($this->operationGenerator->generateSync($this->operationNaming->generateFunctionName($operation), $operation, $context));

            if ($this->generateAsync) {
                $trait->addStmt($this->operationGenerator->generateAsync($this->operationNaming->generateFunctionName($operation), $operation, $context));
            }
        }

        $class->addStmt(new Stmt\TraitUse([
            new Node\Name($group . $suffix . 'Trait'),
        ]));

        return [
            'class' => $factory->namespace($namespace . '\\Resource')
                ->addStmt($factory->use('Jane\OpenApiRuntime\Client\Resource'))
                ->addStmt($class)
                ->getNode(),
            'name' => $group . $suffix,
            'trait' => $factory->namespace($namespace . '\\Resource')
                ->addStmt($factory->use('Jane\OpenApiRuntime\Client\QueryParam'))
                ->addStmt($trait)
                ->getNode(),
        ];
    }
}
