<?php

namespace App\Blueprint;

use App\Database\AbstractBlueprint;

class Registration extends AbstractBlueprint
{
    private string $event_id;
    private string $name;
    private string $email;
    private string $phone;
    private string $shirt_size;
    private string $occupation;
    private string $age;
    private string $address;

    public static function tableName(): string
    {
        return 'registrations';
    }
}
