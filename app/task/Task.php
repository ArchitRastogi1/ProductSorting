<?php

use Services\TaskService;
use Validators\TaskDataValidator;

/**
 * This method returns sorted list based on cheapest prices
 */
$app->get('/task/getCheapestList', function() {

    $taskService = new TaskService();
    $response = $taskService->getOrderedList(SORT_ASC);
    print_r($response);
});


/**
 * This method returns sorted list based on expensive prices
 */
$app->get('/task/getExpensiveList', function() {

    $taskService = new TaskService();
    $response = $taskService->getOrderedList(SORT_DESC);
    print_r($response);
});


/**
 * This method returns cheapest product list based on product Ids (it takes comma seprated list)
 */
$app->get('/task/getCheapestProductIdBasedList', function() use ($app) {

    $productIds = $app->request->get('productIds');
    $productIdArr = explode(",", $productIds); //accepting productId parameter

    $taskService = new TaskService();
    $taskValidator = new TaskDataValidator();
    
    $validatorResponse = $taskValidator->validateProductIds($productIdArr);
    if($validatorResponse === true) {
        $response = $taskService->getProductIdBasedList(SORT_ASC,$productIdArr);
        print_r($response);
    } else {
        echo $validatorResponse;
    }
    
});

/**
 * This method returns Expensive sorted list based on product Ids (it takes comma seprated list)
 */
$app->get('/task/getExpensiveProductIdBasedList', function() use ($app) {

    $productIds = $app->request->get('productIds');
    $productIdArr = explode(",", $productIds); //accepting productId parameter

    $taskService = new TaskService();
    $taskValidator = new TaskDataValidator();
    
    $validatorResponse = $taskValidator->validateProductIds($productIdArr);
    if($validatorResponse === true) {
        $response = $taskService->getProductIdBasedList(SORT_DESC,$productIdArr);
        print_r($response);
    } else {
        echo $validatorResponse;
    }
});
