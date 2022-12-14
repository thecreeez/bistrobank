<?php

final class Database {

    private static $instance;

    private $DEFAULT_BID_PERCENT = 0.05;
    private $DEFAULT_CAPITALIZATION_PERIOD = 30;
    private $database;
    
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $ip = '127.0.0.1';
        $username = 'root';
        $password = '';
        $database = 'bistrobank';

        $this->database = mysqli_connect($ip, $username, $password, $database);
    }

    private function __clone() {
    }

    private function __sleep() {
    }

    private function __wakeup() {

    }

    public function getUserByINN($inn) {
        $query = "SELECT * FROM `client` WHERE `inn` = $inn";
        $result = mysqli_query($this->database, $query);

        if (!$result) {
            return false;
        }

        $parsedResult = array();

        while($row = $result->fetch_assoc()){
            $parsedResult['id'] = $row['id'];
            $parsedResult['fio'] = $row['fio'];
            $parsedResult['inn'] = $row['inn'];
        }

        return $parsedResult;
    }

    public function getOrganizationByINN($inn) {
        $query = "SELECT * FROM `organization` WHERE `inn` = $inn";

        $result = mysqli_query($this->database, $query);

        if (!$result) {
            return false;
        }

        $parsedResult = array();

        while($row = $result->fetch_assoc()){
            $parsedResult['id'] = $row['id'];
            $parsedResult['name'] = $row['name'];
            $parsedResult['ogrn'] = $row['ogrn'];
            $parsedResult['inn'] = $row['inn'];
            $parsedResult['kpp'] = $row['kpp'];
            $parsedResult['address'] = $row['address'];
        }

        return $parsedResult;
    }

    public function insertUser($fio, $inn, $data) {
        $query = "INSERT INTO `client` (`id`, `fio`, `inn`) VALUES (NULL, '$fio', '$inn')";
        $answer = mysqli_query($this->database, $query);

        $client = $this->getUserByINN($inn);

        if ($data['userType'] == 'individual') {
            $client['invidivual'] = $this->insertIndividualClient(
                $client['id'], 
                $data['birthday'], 
                $data['passportFirst'], 
                $data['passportSecond'], 
                $data['passportDate']
            );
        } else {
            $organization = $this->getOrganizationByINN($data['organizationINN']);

            if (!$organization) {
                $this->insertOrganization(
                    $data['organizationName'],
                    $data['organizationOGRN'],
                    $data['organizationINN'],
                    $data['organizationKPP'],
                    $data['organizationAddress']
                );
                $organization = $this->getOrganizationByINN($data['organizationINN']);
            }

            $client['law'] = $this->insertLawClient(
                $client['id'],
                $organization['id']
            );

            $client['organization'] = $organization;
        }

        return $client;
    }

    private function insertLawClient($client_id, $organization_id) {
        $query = "INSERT INTO `client_law` VALUES (NULL, '$client_id', '$organization_id')";
        $answer = mysqli_query($this->database, $query);
    }

    private function insertIndividualClient($client_id, $birthday, $passport_series, $passport_number, $passport_date) {
        $query = "INSERT INTO `client_individual` VALUES (NULL, '$client_id', '$birthday', '$passport_series', '$passport_number', '$passport_date')";
        $answer = mysqli_query($this->database, $query);
    }

    private function insertOrganization($name, $ogrn, $inn, $kpp, $address) {
        $query = "INSERT INTO `organization` VALUES (NULL, '$name', '$ogrn', '$inn', '$kpp', '$address')";
        $answer = mysqli_query($this->database, $query);
    }

    public function insertDepositTicket($client_id, $start_date, $end_date, $amount) {
        // ставка
        $bid = $amount * $this->DEFAULT_BID_PERCENT;

        // надо понять
        $capitalization_period = $this->DEFAULT_CAPITALIZATION_PERIOD;

        $arrayStartDate = explode("-", $start_date);
        $start_date_days = (($arrayStartDate[0] - 2000) * 365) + ($arrayStartDate[1] * 31) + ($arrayStartDate[2]);

        $arrayEndDate = explode("-", $end_date);
        $end_date_days = (($arrayEndDate[0] - 2000) * 365) + ($arrayEndDate[1] * 31) + ($arrayEndDate[2]);
        $term = $end_date_days - $start_date_days;

        if ($capitalization_period > $term) {
            $bid = $this->DEFAULT_BID_PERCENT * ($capitalization_period / $this->DEFAULT_CAPITALIZATION_PERIOD) * $amount;
            $capitalization_period = $term;
        }

        $query = "INSERT INTO `deposit` VALUES (NULL, '$client_id', '$start_date', '$end_date', '$amount', '$bid', '$capitalization_period')";
        $answer = mysqli_query($this->database, $query);

        if ($answer)
            return 'Заявка на вклад успешно создана, спасибо за обращение! Ваш процент: '.$bid.' рублей, следующее начисление процентов через '.$capitalization_period.' дней.';
        else
            return 'Кажется, что-то пошло не так! Наши лучшие умы уже собрались для решения этой проблемы, но, возможно, вы ввели что-то не так';
    }

    public function insertCreditTicket($client_id, $start_date, $end_date, $amount) {
        // срок

        $arrayStartDate = explode("-", $start_date);
        $start_date_days = (($arrayStartDate[0] - 2000) * 365) + ($arrayStartDate[1] * 31) + ($arrayStartDate[2]);

        $arrayEndDate = explode("-", $end_date);
        $end_date_days = (($arrayEndDate[0] - 2000) * 365) + ($arrayEndDate[1] * 31) + ($arrayEndDate[2]);
        $term = $end_date_days - $start_date_days;

        $query = "INSERT INTO `credit` VALUES (NULL, '$client_id', '$start_date', '$end_date', '$term', '$amount')";
        $answer = mysqli_query($this->database, $query);

        if ($answer)
            return 'Заявка на кредит успешно создана, спасибо за обращение!';
        else
            return 'Кажется, что-то пошло не так! Наши лучшие умы уже собрались для решения этой проблемы, но, возможно, вы ввели что-то не так';
    }

    public function check() {
        if (!$this->database)
            return 'Не удалось установить подключение к базе данных. Свяжитесь с администратором (ну а если честно то, вероятно, нужно посмотреть в api/Database.php, там настраивается подключение к БД, скорее всего введен неверный IP-адрес/Данные для входа/Имя БД)';

        return 'OK';
    }

    public function close() {
        mysqli_close($this->database);
    }
}