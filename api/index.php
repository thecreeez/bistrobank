<?php
    require_once('./Application.php');

function route($params) {
    $app = Application::getInstance();
    $userType = $params['userType'];
    $productType = $params['productType'];

    if ($app->checkModules() != 'OK') {
        return 'Проверка модулей выявила неисправность: '.$app->checkModules();
    }

    if (!count($app->getUserWrongFields($userType, $params)) == 0)
        return $app->showErrorPage($app->getUserWrongFields($userType, $params));

    switch ($productType) {
        case 'credit': 
            return $app->createCreditTicket($params);
            break;
        case 'deposit': 
            return $app->createDepositTicket($params);
            break;
        default: 
            return $app->showErrorPage(array('unexpectedProductType'));
    }
}

echo route($_POST);