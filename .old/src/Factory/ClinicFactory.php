<?php

namespace App\Factory;

use App\Entity\Clinic;
use App\Repository\ClinicRepository;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Clinic>
 *
 * @method static Clinic|Proxy createOne(array $attributes = [])
 * @method static Clinic[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Clinic|Proxy find(object|array|mixed $criteria)
 * @method static Clinic|Proxy findOrCreate(array $attributes)
 * @method static Clinic|Proxy first(string $sortedField = 'id')
 * @method static Clinic|Proxy last(string $sortedField = 'id')
 * @method static Clinic|Proxy random(array $attributes = [])
 * @method static Clinic|Proxy randomOrCreate(array $attributes = [])
 * @method static Clinic[]|Proxy[] all()
 * @method static Clinic[]|Proxy[] findBy(array $attributes)
 * @method static Clinic[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Clinic[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ClinicRepository|RepositoryProxy repository()
 * @method Clinic|Proxy create(array|callable $attributes = [])
 */
final class ClinicFactory extends ModelFactory
{
    #[ArrayShape([
        'name' => "string",
        'country' => "string",
        'city' => "string",
        'email' => "string",
        'zipCode' => "string",
        'streetAddress' => "string"
    ])] protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->company(),
            'country' => 'Polska',
            'city' => 'Kraków',
            'email' => self::faker()->email(),
            'zipCode' => $this->getRandomCracowPostCode(),
            'streetAddress' => self::faker()->streetAddress(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Clinic $clinic): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Clinic::class;
    }

    /**
     * @throws Exception
     */
    private function getRandomCracowPostCode(): string
    {
        $first = '3';
        $secondArray = ['0', '1'];
        $second = $secondArray[array_rand($secondArray)];
        $result = sprintf('%s%s-', $first, $second);
        for ($i = 0; $i < 3; $i++) {
            $result .= random_int(0, 9);
        }

        return $result;
    }
}
