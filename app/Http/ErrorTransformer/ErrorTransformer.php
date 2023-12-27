<?php
declare(strict_types=1);

namespace App\Http\ErrorTransformer;

use Psr\Log\LoggerInterface;

class ErrorTransformer
{
    private readonly LoggerInterface $logger;
    /**
     * @var ErrorTransformerInterface[]
     */
    private array $transformers = [];

    public function __construct(LoggerInterface $logger, ErrorTransformerInterface ...$transformers)
    {
        $this->logger = $logger;

        foreach ($transformers as $transformer) {
            $this->transformers[$transformer->getSupportedErrorClass()] = $transformer;
        }
    }

    public function transform(object $error): string
    {
        if (false === \array_key_exists($error::class, $this->transformers)) {
            throw new \InvalidArgumentException('No transformer found');
        }

        $translation = $this->transformers[$error::class]->transform($error);

        if (null === $translation) {
            $this->logger->error('Cannot transform an error', ['class' => $error::class, 'code' => $error->getErrors()]);
        }

        return (string) $translation;
    }
}
