<?php

namespace App\Tests\Service\Patient;

use App\Entity\PatientData;
use App\Service\Patient\PeselDataHelper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PeselDataHelperTest extends TestCase
{
    private PeselDataHelper $peselDataHelper;

    /**
     * @dataProvider getGenderTestCases
     */
    public function testGetGender(string $pesel, string $expected): void
    {
        $this->assertSame($expected, $this->peselDataHelper->getGender($pesel));
    }

    /**
     * @dataProvider getBornDateTestCases
     */
    public function testGetBornDate(string $pesel, DateTimeImmutable $expectedDate): void
    {
        $this->assertSame(
            $expectedDate->format('Y-m-d'),
            $this->peselDataHelper->getBornDate($pesel)->format('Y-m-d')
        );
    }

    public function getGenderTestCases(): array
    {
        return [
            ['00000000070', PatientData::GENDER_MALE],
            ['00000000080', PatientData::GENDER_FEMALE],
        ];
    }

    public function getBornDateTestCases(): array
    {
        return [
            ['99021704138', new DateTimeImmutable('1999-02-17')],
            ['91012486951', new DateTimeImmutable('1991-01-24')],
            ['66062753519', new DateTimeImmutable('1966-06-27')],
            ['10261732604', new DateTimeImmutable('2010-06-17')],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->peselDataHelper = new PeselDataHelper();
    }
}
