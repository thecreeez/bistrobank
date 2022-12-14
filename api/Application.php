<?php
    require_once('./Database.php');

class Application {
    private static $instance;
    private $db;
    
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->db = Database::getInstance();
    }

    private function __clone() {
    }

    private function __sleep() {
    }

    private function __wakeup() {

    }

    public function getUserWrongFields($userType, $params) {
        switch ($userType) {
            case 'individual': return $this->getErrorIndividualUserFields($params);
            case 'entity': return $this->getErrorEntityUserFields($params);

            default: return array(
                'Usertype error'
            );
        }
    }

    private function getErrorIndividualUserFields($params) {
        $errors = array();

        $name = $params['name'];

        if (count(explode(' ', $name)) < 2) {
            array_push($errors, 'Не введено имя/фамилия');
        }

        $inn = $params['inn'];

        if (strlen($inn) != 12) {
            array_push($errors, 'ИНН должен содержать 12 символов');
        }

        if (!preg_match("/^([0-9])+$/", $inn)) {
            array_push($errors, 'ИНН может содержать только цифры');
        }

        $birthday = $params['birthday'];

        $passportFirst = $params['passportFirst'];

        if (strlen($passportFirst) != 4) {
            array_push($errors, 'Серия паспорта должна содержать только 4 символа');
        }

        if (!preg_match("/^([0-9])+$/", $passportFirst)) {
            array_push($errors, 'Серия паспорта может содержать только цифры');
        }

        $passportSecond = $params['passportSecond'];

        if (strlen($passportSecond) != 6) {
            array_push($errors, 'Номер паспорта должен содержать только 6 символа');
        }

        if (!preg_match("/^([0-9])+$/", $passportSecond)) {
            array_push($errors, 'Номер паспорта может содержать только цифры');
        }

        $passportDate = $params['passportDate'];

        return $errors;
    }

    private function getErrorEntityUserFields($params) {
        $errors = array();

        $name = $params['eName'];

        if (explode(' ', $name) < 2) {
            array_push($errors, 'Не введено имя/фамилия');
        }

        $inn = $params['eInn'];

        if (strlen($inn) != 12) {
            array_push($errors, 'ИНН должен содержать 12 символов');
        }

        if (!preg_match("/^([0-9])+$/", $inn)) {
            array_push($errors, 'ИНН может содержать только цифры');
        }

        $organizationName = $params['organizationName'];
        $organizationAddress = $params['organizationAddress'];

        $organizationOGRN = $params['organizationOGRN'];

        if (strlen($organizationOGRN) != 13) {
            array_push($errors, 'ОГРН должен содержать 13 символов');
        }

        if (!preg_match("/^([0-9])+$/", $organizationOGRN)) {
            array_push($errors, 'ОГРН может содержать только цифры');
        }

        $organizationINN = $params['organizationINN'];

        if (strlen($organizationINN) != 10) {
            array_push($errors, 'ИНН организации должен содержать 10 символов');
        }

        if (!preg_match("/^([0-9])+$/", $organizationINN)) {
            array_push($errors, 'ИНН организации может содержать только цифры');
        }

        $organizationKPP = $params['organizationKPP'];

        if (strlen($organizationKPP) != 9) {
            array_push($errors, 'КПП организации может содержать только цифры');
        }

        if (!preg_match("/^([0-9])+$/", $organizationKPP)) {
            array_push($errors, 'КПП организации может содержать только цифры');
        }

        return $errors;
    }

    private function getErrorCreditFields($params) {
        $errors = array();
        $amount = $params['creditSummary'];

        if ($amount == '') {
            array_push($errors, 'Не заполнено поле СУММА');
        } else {
            if (!preg_match("/^([0-9])+$/", $amount)) {
                array_push($errors, 'Сумма кредита должна содержать только цифры');
            }
    
            if (floatval($amount) <= 0) {
                array_push($errors, 'Сумма кредита должна превышать 0');
            }
        }

        return $errors;
    }

    private function getUser($params) {
        $fio = '';
        $inn = '';
        $data = array(
            'userType' => $params['userType']
        );

        if ($params['userType'] == 'individual') {
            $fio = $params['name'];
            $inn = $params['inn'];

            $data['birthday'] = $params['birthday'];
            $data['passportFirst'] = $params['passportFirst'];
            $data['passportSecond'] = $params['passportSecond'];
            $data['passportDate'] = $params['passportDate'];
        } else {
            $fio = $params['eName'];
            $inn = $params['eInn'];

            $data['organizationName'] = $params['organizationName'];
            $data['organizationAddress'] = $params['organizationAddress'];
            $data['organizationOGRN'] = $params['organizationOGRN'];
            $data['organizationINN'] = $params['organizationINN'];
            $data['organizationKPP'] = $params['organizationKPP'];
        }

        $user = $this->db->getUserByINN($inn);

        if (!$user) {
            $user = $this->db->insertUser($fio, $inn, $data);
        }

        return $user;
    }

    private function getErrorDepositFields($params) {
        $errors = array();
        $amount = $params['depositBet'];

        if ($amount == '') {
            array_push($errors, 'Не заполнено поле СУММА');
        } else {
            if (!preg_match("/^([0-9])+$/", $amount)) {
                array_push($errors, 'Сумма вклада должна содержать только цифры');
            }
    
            if (floatval($amount) <= 0) {
                array_push($errors, 'Сумма вклада должна превышать 0');
            }
        }

        return $errors;
    }

    public function createCreditTicket($params) {
        if (count($this->getErrorCreditFields($params)) != 0) {
            return serialize($this->getErrorCreditFields($params));
        }
        $user = $this->getUser($params);

        $answer = $this->db->insertCreditTicket($user['id'], $params['creditOpenDate'], $params['creditCloseDate'], $params['creditSummary']);

        $this->db->close();

        return $answer;
    }

    public function createDepositTicket($params) {
        if (count($this->getErrorDepositFields($params)) != 0) {
            return serialize($this->getErrorDepositFields($params));
        }
        $user = $this->getUser($params);

        $answer = $this->db->insertDepositTicket($user['id'], $params['depositOpenDate'], $params['depositCloseDate'], $params['depositBet']);

        $this->db->close();

        return $answer;
    }

    public function getUserByINN($inn) {
        $toReturn = $this->db->getUserByINN($inn);

        $this->db->close();
        return $toReturn;
    }

    public function showErrorPage($errors) {
        return serialize($errors);
    }

    public function checkModules() {
        return $this->db->check();
    }
}