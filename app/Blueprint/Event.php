<?php

namespace App\Blueprint;

use App\Database\AbstractBlueprint;

class Event extends AbstractBlueprint
{
    private string $title;
    private string $description;

    public static function tableName(): string
    {
        return 'events';
    }
}
