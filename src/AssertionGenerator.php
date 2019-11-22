<?php

declare(strict_types=1);

namespace webignition\BasilAssertionGenerator;

use webignition\BasilModel\Assertion\AssertionInterface;
use webignition\BasilModelFactory\AssertionFactory;
use webignition\BasilModelFactory\Exception\EmptyAssertionStringException;
use webignition\BasilModelFactory\Exception\MissingComparisonException;
use webignition\BasilModelFactory\Exception\MissingValueException;
use webignition\BasilParser\AssertionParser;

class AssertionGenerator
{
    private $assertionParser;
    private $assertionFactory;

    public function __construct(AssertionParser $assertionParser, AssertionFactory $assertionFactory)
    {
        $this->assertionParser = $assertionParser;
        $this->assertionFactory = $assertionFactory;
    }

    public static function createGenerator(): AssertionGenerator
    {
        return new AssertionGenerator(
            AssertionParser::create(),
            AssertionFactory::createFactory()
        );
    }

    /**
     * @param string $assertionString
     *
     * @return AssertionInterface
     *
     * @throws MissingValueException
     * @throws EmptyAssertionStringException
     * @throws MissingComparisonException
     */
    public function generate(string $assertionString): AssertionInterface
    {
        $assertion = $this->assertionParser->parse($assertionString);

        return $this->assertionFactory->createFromAssertionData($assertion);
    }
}
