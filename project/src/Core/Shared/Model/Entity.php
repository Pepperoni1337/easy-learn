<?php

namespace App\Core\Shared\Model;

interface Entity
{
    public const ID = 'id';

    public function getId(): Id;
}
