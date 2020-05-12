<?php

declare(strict_types=1);

namespace Hazhir;

use Rubix\ML\Classifiers\ClassificationTree;
use Rubix\ML\Classifiers\ExtraTreeClassifier;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\NaiveBayes;
use Rubix\ML\Extractors\CSV;

class CustomerRiskPrediction
{
    private NaiveBayes $estimatorForQuestionOne;
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
            'Poor',
            '3 Years',
            'Medium'
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




//    private $data = [
//        ['sunny',       85,    85,    'false',    'Dont_play'],
//        ['sunny',       80,    90,    'true',     'Dont_play'],
//        ['overcast',    83,    78,    'false',    'Play'],
//        ['rain',        70,    96,    'false',    'Play'],
//        ['rain',        68,    80,    'false',    'Play'],
//        ['rain',        65,    70,    'true',     'Dont_play'],
//        ['overcast',    64,    65,    'true',     'Play'],
//        ['sunny',       72,    95,    'false',    'Dont_play'],
//        ['sunny',       69,    70,    'false',    'Play'],
//        ['rain',        75,    80,    'false',    'Play'],
//        ['sunny',       75,    70,    'true',     'Play'],
//        ['overcast',    72,    90,    'true',     'Play'],
//        ['overcast',    81,    75,    'false',    'Play'],
//        ['rain',        71,    80,    'true',     'Dont_play'],
//    ];
//
//    private function getData($input)
//    {
//        $targets = array_column($input, 4);
//        array_walk($input, static function (&$v): void {
//            array_splice($v, 4, 1);
//        });
//
//        return [$input, $targets];
//    }
//
//    public function predictRisk(array $data): array
//    {
//        $classifier = new NaiveBayes();
//        $classifier->train(self::SAMPLES, self::LABELS);
//        return $classifier->predict($data);
//    }
//
//    public function createDecisionTreeForRiskPrediction()
//    {
////        $decisionTree= new DecisionTree();
////        $decisionTree->train(self::SAMPLES, self::LABELS);
////        return $decisionTree->getHtml();
//
//        [$data, $targets] = $this->getData($this->data);
//        $classifier = new DecisionTree(5);
//        $classifier->train($data, $targets);
//        return $classifier->getHtml();
//    }
//
//    public function createNaiveBayesForIrisFlower(): void
//    {
//        $dataset = new CsvDataset(__DIR__.'/irisFlower.csv', 4, true);
//        $classifier = new NaiveBayes();
//        $classifier->train($dataset->getSamples(), $dataset->getTargets());
//        ///display the naive bayes
//    }
//
//    public function createDecisionTreeForIrisFLower(): DecisionTree
//    {
//        try {
//            $dataset = new CsvDataset(__DIR__ . '/irisFlower.csv', 4, true);
//            $decisionTree = new DecisionTree();
//            $decisionTree->train($dataset->getSamples(), $dataset->getTargets());
//            return $decisionTree;
//        } catch (FileException $e) {
//            $e->getMessage();
//        }
//
//    }

    private function loadDataset(): Labeled
    {
        return new Labeled(self::SAMPLES, self::LABELS);
    }

    private function trainTheEstimator(): bool
    {
        $this->estimatorForQuestionOne = new NaiveBayes();
        $this->estimatorForQuestionOne->train($this->loadDataset());
        return $this->estimatorForQuestionOne->trained();
    }


    //first question الف
    public function predictFirstUserRisk(): string
    {
        if ($this->trainTheEstimator()) {
            return $this->estimatorForQuestionOne->predictSample(['Excellent', '5 Years', 'Low']);
        }
        return 'something went wrong';

    }


    //second question ب
    public function createDecisionTree(): array
    {
//        $estimator = new ClassificationTree(10, 7, 4, 0.01);
        $estimator = new ExtraTreeClassifier(50, 3, 4, 1e-7);
        $estimator->train($this->loadDataset());
        $prediction = $estimator->predictSample(['Poor', '5 Years', 'Low']);
        $rules = $estimator->rules();
        return [
            'prediction' => $prediction,
            'rules' => $rules
        ];
    }

    //second question but with naive bayes ب
    public function predictSecondUserRisk(): string
    {
        if ($this->trainTheEstimator()) {
            return $this->estimatorForQuestionOne->predictSample(['Poor', '5 Years', 'Low']);
        }
        return 'something went wrong';
    }


    //second part of the question
    private function get25RandomDataFromIrisDataset(): Labeled
    {
        $dataset = Labeled::fromIterator(new CSV(__DIR__.'/irisFlower.csv', true, ','));
        return $dataset->randomize()->take(25);

    }

    public function irisDecisionTree(): string
    {
        $estimator = new ClassificationTree(10, 7, 5, 0.01);
        $estimator->train($this->get25RandomDataFromIrisDataset());
        return $estimator->rules();
    }

    public function irisNaiveBayes(): array
    {
        $estimator = new NaiveBayes();
        $estimator->train($this->get25RandomDataFromIrisDataset());
        return $estimator->priors();
    }

}
