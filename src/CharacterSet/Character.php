<?php

declare(strict_types=1);

namespace jblond\morse\CharacterSet;

interface Character
{
    /**
     * @return array
     */
    public function get(): array;
}
