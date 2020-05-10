<?php

declare(strict_types=1);

use Hazhir\CustomerRiskPrediction;

require '../vendor/autoload.php';

//phpinfo();

$customersRisk = new CustomerRiskPrediction();
//$customerResults = $customersRisk->predictRisk([
//    ['Excellent', '5 Years', 'Low'],
//    ['Poor', '5 Years', 'Low']
//]);


$customersRisk->createDecisionTree();

//foreach ($customerResults as $key => $result) {
//    echo '<pre>';
//        echo 'User'. ($key + 1) . ': ' . $result;
//        echo '<br/>';
//    echo '</pre>';
//}
