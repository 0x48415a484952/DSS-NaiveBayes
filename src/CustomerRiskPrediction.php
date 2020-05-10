<?php

declare(strict_types=1);

namespace Hazhir;

use Phpml\Classification\DecisionTree;
use Phpml\Classification\NaiveBayes;
use Phpml\Dataset\CsvDataset;
use Phpml\Exception\FileException;

class CustomerRiskPrediction
{
    private const SAMPLES = [
        [
            'Excellent',
            '3 Years',
            'High'
        ],
        [
            'Fair',
            '5 Years',
            'Low'
        ],
        [
            'Fair',
            '3 Years',
            'High'
        ],
        [
            'Poor',
            '5 Years',
            'High',
        ],
        [
            'Excellent',
            '3 Years',
            'Low'
        ],
        [
            'Fair',
            '5 Years',
            'Medium'
        ],
        [
            'Poor',
            '3 Years',
            'High'
        ],
        [
            'Poor',
            '5 Years',
            'Low'
        ],
        [
            'Fair',
            '3 Years',
            'High'
        ],
        [
            'Excellent',
            '5 Years',
            'Medium'
        ],
        [
            'Poor',
            '5 Years',
            'Medium'
        ],
        [
            'Fair',
            '3 Years',
            'Low'
        ],
        [
            'Fair',
            '5 Years',
            'Low'
        ],
        [
            'Excellent',
            '5 Years',
            'High'
        ],
    ];

    private const LABELS = [
        'safe',
        'risky',
        'safe',
        'risky',
        'risky',
        'safe',
        'risky',
        'safe',
        'safe',
        'safe',
        'safe',
        'risky',
        'risky',
        'safe'
    ];

    public function predictRisk(array $data): array
    {
        $classifier = new NaiveBayes();
        $classifier->train(self::SAMPLES, self::LABELS);
        return $classifier->predict($data);
    }

    public function createDecisionTree()
    {
        try {
            $temp = [];
            $dataset = new CsvDataset(__DIR__.'/happyScore.csv', 10, true);

            foreach ($dataset->getSamples() as $key => $item) {
                $temp[$key] = [$item[4], $item[8]];
            }
//            print_r($temp);

            $classifier = new NaiveBayes();
            $classifier->train($temp, $dataset->getTargets());
//            echo $classifier->predict([10, 1]);

            $decisionTree= new DecisionTree(5);
            $decisionTree->train($temp, $dataset->getTargets());
            $decisionTree->getHtml();
        } catch (FileException $e) {
            return $e->getMessage();
        }
    }
}
