<?php

namespace AspearIT\Codensultancy\Input;

interface InputInterface
{
    /**
     * Source of the PHP code to evaluate.
     *
     * @return string
     */
    public function getPHPAsString(): string;
}