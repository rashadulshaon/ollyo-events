<?php

namespace App\Blueprint;

use App\Database\AbstractBlueprint;

class Event extends AbstractBlueprint
{
    private string $title;
    private string $summary;
    private string $image_url;
    private int $max_participants;

    public static function tableName(): string
    {
        return 'events';
    }
}
