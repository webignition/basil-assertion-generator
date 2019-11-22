<?php

declare(strict_types=1);

namespace webignition\BasilAssertionGenerator\Tests\Unit;

use webignition\BasilAssertionGenerator\AssertionGenerator;
use webignition\BasilModel\Assertion\AssertionComparison;
use webignition\BasilModel\Assertion\AssertionInterface;
use webignition\BasilModel\Assertion\ExaminationAssertion;
use webignition\BasilModel\Identifier\DomIdentifier;
use webignition\BasilModel\Value\DomIdentifierValue;

class AssertionGeneratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider generateDataProvider
     */
    public function testGenerate(string $assertionString, AssertionInterface $expectedAssertion)
    {
        $assertionGenerator = AssertionGenerator::createGenerator();

        $this->assertEquals($expectedAssertion, $assertionGenerator->generate($assertionString));
    }

    public function generateDataProvider(): array
    {
        return [
            'exists, css selector' => [
                'assertionString' => '".selector" exists',
                'expectedAssertion' => new ExaminationAssertion(
                    '".selector" exists',
                    new DomIdentifierValue(
                        new DomIdentifier('.selector')
                    ),
                    AssertionComparison::EXISTS
                ),
            ],
            'exists, xpath expression containing escaped double quotes' => [
                'actionString' => '"//*[@id=\"element-id\"]" exists',
                'expectedAssertion' => new ExaminationAssertion(
                    '"//*[@id=\"element-id\"]" exists',
                    new DomIdentifierValue(
                        new DomIdentifier('//*[@id="element-id"]')
                    ),
                    AssertionComparison::EXISTS
                ),
            ],
        ];
    }
}
