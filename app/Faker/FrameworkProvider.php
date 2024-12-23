<?php
namespace App\Faker;
use Faker\Provider\Base;
class FrameworkProvider extends Base
{
    protected static $names = [
        'CakePHP',
        'CodeIgniter',
        'Laravel',
        'Lumen',
        'Phalcon',
        'Slim',
        'Symfony',
    ];
    public function framework(): string
    {
        return static::randomElement(static::$names);
    }
}