<?php

namespace TinyBlocks\Vo\Internal\Exceptions;

use RuntimeException;

final class PropertyCannotBeDeactivated extends RuntimeException
{
    public function __construct(string $key, string $class)
    {
        $template = 'Property <%s> cannot be deactivated in class <%s>.';
        parent::__construct(message: sprintf($template, $key, $class));
    }
}
