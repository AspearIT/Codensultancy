<?php

namespace AspearIT\Codensultancy\PHParser\Exception;

use PhpParser\Node;

class UnsupportedNodeException extends \Exception
{
    public static function forNode(Node $node): self
    {
        dd("In default context: ",  $node);
        return new self("Unsupported node: " . get_class($node));
    }

    public static function forNodeAsPartOfClass(Node $node): self
    {
        dd("In class context: ",  $node);
        return new self("Unsupported node in class context: " . get_class($node));
    }
}