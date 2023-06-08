<?php

namespace TinyBlocks\Vo\Internal\Exceptions;

use RuntimeException;

final class PropertyCannotBeChanged extends RuntimeException
{
    public function __construct(string $key, string $class)
    {
        $template = 'Property <%s> cannot be changed in class <%s>.';
        parent::__construct(message: sprintf($template, $key, $class));
    }
}
