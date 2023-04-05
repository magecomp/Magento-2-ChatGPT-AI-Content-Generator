<?php

namespace Magecomp\Chatgptaicontent\Api\Data;

interface QueryAttributeInterface
{
    public function getValue(): string;
    public function getName(): string;
}
