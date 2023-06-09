<?php

namespace AspearIT\Codensultancy\CodeType;

enum CodeType
{
    case FRAMEWORK;
    case FULL_APPLICATION;

    case CONTROLLER;
    case BUSINESS_LOGIC;
    case INFRASTRUCTURE;

    case UNDEFINED;
}
