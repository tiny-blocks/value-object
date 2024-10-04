<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal\Exceptions;

use RuntimeException;

final class InvalidProperty extends RuntimeException
{
    public function __construct(string $key, string $class)
    {
        $template = 'Invalid property <%s> for class <%s>.';
        parent::__construct(message: sprintf($template, $key, $class));
    }
}
