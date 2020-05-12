<?php

declare(strict_types=1);

use Hazhir\CustomerRiskPrediction;

require '../vendor/autoload.php';

$customersRisk = new CustomerRiskPrediction();



//question number one الف
//$customersRisk->predictFirstUserRisk();

//question number two ب
//echo $customersRisk->createDecisionTree();

//question number three ج
$result = $customersRisk->createDecisionTree();
echo $result['rules'];
echo 'final result: ' . $result['prediction'];


//second part of the homework
//echo $customersRisk->irisDecisionTree();
//print_r($customersRisk->irisNaiveBayes());


