<?php
class Database {

    private $envFile;

    public $connection;

    public $email;
    public $phone;
    public $address;
    public $employeeID;
    public $updateSuccess = null;

    public function Connect(){
        $this->connection = null;
        $this->envFile = parse_ini_file('.env');
        try {
            $this->connection = new PDO(
                "mysql:host=".$this->envFile['DBHOST'].";dbname=".
                $this->envFile['DBNAME'],$this->envFile['DBUSERNAME'],$this->envFile['DBUSER_PASSWORD']);
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }

        return $this->connection;
    }

    function getEmployees(){
        $employeesQuery = "select
                                em.employeeID,
                                `name`,
                                birthdate,
                                SSN,
                                isEmployee,
                                email,
                                phone,
                                address,
                                inf.employee_introduction_english,
                                inf.employee_introduction_spanish,
                                inf.employee_introduction_french,
                                inf.employee_experience,
                                inf.employee_experience_english,
                                inf.employee_experience_spanish,
                                inf.employee_experience_french,
                                inf.employee_education,
                                inf.employee_education_english,
                                inf.employee_education_spanish,
                                inf.employee_education_french
                           from Employees as em
                           inner join Contact co on em.employeeID=co.employeeID
                           left join Information inf on inf.employeeID=em.employeeID
                           order by em.employeeID desc";

        if (!$this->Connect()->query($employeesQuery)){
            $listException = new Exception();
            throw new Exception($listException->getMessage());
        }else{
            return $this->Connect()->query($employeesQuery);
        }
    }

    function updateEmployee(array $values)
    {
        $updateQuery = "update contact set email=:email,phone=:phone,address=:address where employeeID=:employeeID";

        $insert = "insert into UpdateLog
                    (
                    employeeID,
                    email,
                    email_old,
                    phone,
                    phone_old,
                    address,
                    address_old,
                    updatedBy
                    )
                    value
                    (
                    :employeeID,
                    :email,
                    :email_old,
                    :phone,
                    :phone_old,
                    :address,
                    :address_old,
                    :updatedBy
                    )";

        $updateCommand = $this->Connect()->prepare($updateQuery);
        $insertCommand = $this->Connect()->prepare($insert);

        $this->employeeID = htmlspecialchars(strip_tags($values[0]));
        $this->email = htmlspecialchars(strip_tags($values[1]));
        $this->phone = htmlspecialchars(strip_tags($values[2]));
        $this->address = htmlspecialchars(strip_tags($values[3]));
        $this->email_old = htmlspecialchars(strip_tags($values[4]));
        $this->phone_old = htmlspecialchars(strip_tags($values[5]));
        $this->address_old = htmlspecialchars(strip_tags($values[6]));

        $updateCommand->bindParam(":email", $this->email);
        $updateCommand->bindParam(":phone", $this->phone);
        $updateCommand->bindParam(":address", $this->address);
        $updateCommand->bindParam(":employeeID", $this->employeeID);

        $insertCommand->bindParam(":employeeID", $this->employeeID);
        $insertCommand->bindParam(":email", $this->email);
        $insertCommand->bindParam(":phone", $this->phone);
        $insertCommand->bindParam(":address", $this->address);
        $insertCommand->bindParam(":email_old", $this->email_old);
        $insertCommand->bindParam(":phone_old", $this->phone_old);
        $insertCommand->bindParam(":address_old", $this->address_old);
        $insertCommand->bindParam(":updatedBy", $_SERVER['REMOTE_ADDR']);

        try {
            $insertCommand->execute();
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        if ($updateCommand->execute()) {
            $this->updateSuccess = "<div class='alert alert-success' id='mainAlertMessage'>
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">
                                        <span aria-hidden=\"true\" aria-label='Close'>&times;</span></button>
                                        <strong>Employee is updated.</strong></div>";
        } else {
            $issue = new Exception();
            throw new Exception($issue->getMessage());
        }
    }

    function updateInformation(array $values)
    {

        $updateQuery = "update information
        set employee_introduction_english=:employee_introduction_english,
        employee_introduction_spanish=:employee_introduction_spanish,
        employee_introduction_french=:employee_introduction_french,
        employee_experience=:employee_experience,
        employee_experience_english=:employee_experience_english,
        employee_experience_spanish=:employee_experience_spanish,
        employee_experience_french=:employee_experience_french,
        employee_education=:employee_education,
        employee_education_english=:employee_education_english,
        employee_education_spanish=:employee_education_spanish,
        employee_education_french=:employee_education_french
        where employeeID=:employeeID";

        $insert = "insert into UpdateLog
(
employeeID,
employee_introduction_english,
employee_introduction_english_old,
employee_introduction_spanish,
employee_introduction_spanish_old,
employee_introduction_french,
employee_introduction_french_old,
employee_experience,
employee_experience_old,
employee_experience_english,
employee_experience_english_old,
employee_experience_spanish,
employee_experience_spanish_old,
employee_experience_french,
employee_experience_french_old,
employee_education,
employee_education_old,
employee_education_english_old,
employee_education_english,
employee_education_spanish,
employee_education_spanish_old,
employee_education_french,
employee_education_french_old,
updatedBy
)
value
(
:employeeID,
:employee_introduction_english,
:employee_introduction_english_old,
:employee_introduction_spanish,
:employee_introduction_spanish_old,
:employee_introduction_french,
:employee_introduction_french_old,
:employee_experience,
:employee_experience_old,
:employee_experience_english,
:employee_experience_english_old,
:employee_experience_spanish,
:employee_experience_spanish_old,
:employee_experience_french,
:employee_experience_french_old,
:employee_education,
:employee_education_old,
:employee_education_english_old,
:employee_education_english,
:employee_education_spanish,
:employee_education_spanish_old,
:employee_education_french,
:employee_education_french_old,
:updatedBy
)";

        $updateCommand = $this->Connect()->prepare($updateQuery);
        $insertCommand = $this->Connect()->prepare($insert);

        $this->employeeID = htmlspecialchars(strip_tags($values[0]));
        $this->employee_introduction_english = htmlspecialchars(strip_tags($values[1]));
        $this->employee_introduction_spanish = htmlspecialchars(strip_tags($values[2]));
        $this->employee_introduction_french = htmlspecialchars(strip_tags($values[3]));
        $this->employee_experience = htmlspecialchars(strip_tags($values[4]));
        $this->employee_experience_english = htmlspecialchars(strip_tags($values[5]));
        $this->employee_experience_spanish = htmlspecialchars(strip_tags($values[6]));
        $this->employee_experience_french = htmlspecialchars(strip_tags($values[7]));
        $this->employee_education = htmlspecialchars(strip_tags($values[8]));
        $this->employee_education_english = htmlspecialchars(strip_tags($values[9]));
        $this->employee_education_spanish = htmlspecialchars(strip_tags($values[10]));
        $this->employee_education_french = htmlspecialchars(strip_tags($values[11]));
        $this->employee_introduction_english_old = htmlspecialchars(strip_tags($values[12]));
        $this->employee_introduction_spanish_old = htmlspecialchars(strip_tags($values[13]));
        $this->employee_introduction_french_old = htmlspecialchars(strip_tags($values[14]));
        $this->employee_experience_old = htmlspecialchars(strip_tags($values[15]));
        $this->employee_experience_english_old = htmlspecialchars(strip_tags($values[16]));
        $this->employee_experience_spanish_old = htmlspecialchars(strip_tags($values[17]));
        $this->employee_experience_french_old = htmlspecialchars(strip_tags($values[18]));
        $this->employee_education_old = htmlspecialchars(strip_tags($values[19]));
        $this->employee_education_english_old = htmlspecialchars(strip_tags($values[20]));
        $this->employee_education_spanish_old = htmlspecialchars(strip_tags($values[21]));
        $this->employee_education_french_old = htmlspecialchars(strip_tags($values[22]));

        $updateCommand->bindParam(":employee_introduction_english", $this->employee_introduction_english);
        $updateCommand->bindParam(":employee_introduction_spanish", $this->employee_introduction_spanish);
        $updateCommand->bindParam(":employee_introduction_french", $this->employee_introduction_french);
        $updateCommand->bindParam(":employee_experience", $this->employee_experience);
        $updateCommand->bindParam(":employeeID", $this->employeeID);
        $updateCommand->bindParam(":employee_experience_english", $this->employee_experience_english);
        $updateCommand->bindParam(":employee_experience_spanish", $this->employee_experience_spanish);
        $updateCommand->bindParam(":employee_experience_french", $this->employee_experience_french);
        $updateCommand->bindParam(":employee_education", $this->employee_education);
        $updateCommand->bindParam(":employee_education_english", $this->employee_education_english);
        $updateCommand->bindParam(":employee_education_spanish", $this->employee_education_spanish);
        $updateCommand->bindParam(":employee_education_french", $this->employee_education_french);

        $insertCommand->bindParam(":employeeID", $this->employeeID);
        $insertCommand->bindParam(":employee_introduction_english", $this->employee_introduction_english);
        $insertCommand->bindParam(":employee_introduction_english_old", $this->employee_introduction_english_old);
        $insertCommand->bindParam(":employee_introduction_spanish", $this->employee_introduction_spanish);
        $insertCommand->bindParam(":employee_introduction_spanish_old", $this->employee_introduction_spanish_old);
        $insertCommand->bindParam(":employee_introduction_french", $this->employee_introduction_french);
        $insertCommand->bindParam(":employee_introduction_french_old", $this->employee_introduction_french_old);
        $insertCommand->bindParam(":employee_experience", $this->employee_experience);
        $insertCommand->bindParam(":employee_experience_old", $this->employee_experience_old);
        $insertCommand->bindParam(":employee_experience_english", $this->employee_experience_english);
        $insertCommand->bindParam(":employee_experience_english_old", $this->employee_experience_english_old);
        $insertCommand->bindParam(":employee_experience_spanish", $this->employee_experience_spanish);
        $insertCommand->bindParam(":employee_experience_spanish_old", $this->employee_experience_spanish_old);
        $insertCommand->bindParam(":employee_experience_french", $this->employee_experience_french);
        $insertCommand->bindParam(":employee_experience_french_old", $this->employee_experience_french_old);
        $insertCommand->bindParam(":employee_education", $this->employee_education);
        $insertCommand->bindParam(":employee_education_old", $this->employee_education_old);
        $insertCommand->bindParam(":employee_education_english", $this->employee_education_english);
        $insertCommand->bindParam(":employee_education_english_old", $this->employee_education_english_old);
        $insertCommand->bindParam(":employee_education_spanish", $this->employee_education_spanish);
        $insertCommand->bindParam(":employee_education_spanish_old", $this->employee_education_spanish_old);
        $insertCommand->bindParam(":employee_education_french", $this->employee_education_french);
        $insertCommand->bindParam(":employee_education_french_old", $this->employee_education_french_old);

        // It will insert "::1" to the updatedBy column if the application is running on localhost.
        $insertCommand->bindParam(":updatedBy", $_SERVER['REMOTE_ADDR']);

        try {
            $insertCommand->execute();
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        if ($updateCommand->execute()) {
            $this->updateSuccess = "<div class='alert alert-success' id='mainAlertMessage'>
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">
                                        <span aria-hidden=\"true\" aria-label='Close'>&times;</span></button>
                                        <strong>Employee information is updated.</strong></div>";
        } else {
            $issue = new Exception();
            throw new Exception($issue->getMessage());
        }
    }
}