<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Output\Node\Printer\JUnit;

use Behat\Behat\Output\Node\Printer\FeaturePrinter;
use Behat\Behat\Tester\Result\StepResult;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Behat\Output\Statistics\Statistics;

/**
 * Prints the <testsuite> element.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
final class JUnitFeaturePrinter implements FeaturePrinter
{
    /**
     * @var Statistics
     */
    private $statistics;

    public function __construct(Statistics $statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * {@inheritDoc}
     */
    public function printHeader(Formatter $formatter, FeatureNode $feature)
    {
        $stats = $this->statistics->getScenarioStatCounts();

        if (0 === count($stats)) {
            $totalCount = 0;
        } else {
            $totalCount = array_sum($stats);
        }

        $formatter->getOutputPrinter()->addTestsuite(array(
            'name' => $feature->getTitle(),
            'tests' => $totalCount,
            'failures' => $stats[TestResult::FAILED],
            'errors' => $stats[TestResult::PENDING] + $stats[StepResult::UNDEFINED],
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function printFooter(Formatter $formatter, TestResult $result)
    {
    }
}