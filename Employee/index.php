<?php
include_once 'inc/db.php';
$connection = new Database();
$database = $connection->Connect();
if (isset($_GET['submit'])){

    $data = array(
        $employeeID = $_GET['employeeID'],
        $employee_email = $_GET['employee_email'],
        $employee_phone = $_GET['employee_phone'],
        $employee_address = $_GET['employee_address'],


        $employee_email = $_GET['email_old'],
        $employee_phone = $_GET['phone_old'],
        $employee_address = $_GET['address_old']
    );

    $connection->updateEmployee($data);
}


if (isset($_GET['update'])){


    $data = array(
        $employeeID = $_GET['employeeID'],
        $employee_introduction_english = $_GET['employee_introduction_english'],
        $employee_introduction_spanish = $_GET['employee_introduction_spanish'],
        $employee_introduction_french = $_GET['employee_introduction_french'],
        $employee_experience = $_GET['employee_experience'],
        $employee_experience_english = $_GET['employee_experience_english'],
        $employee_experience_spanish = $_GET['employee_experience_spanish'],
        $employee_experience_french = $_GET['employee_experience_french'],
        $employee_education = $_GET['employee_education'],
        $employee_education_english = $_GET['employee_education_english'],
        $employee_education_spanish = $_GET['employee_education_spanish'],
        $employee_education_french = $_GET['employee_education_french'],


        $employee_introduction_english_old = $_GET['employee_introduction_english_old'],
        $employee_introduction_spanish_old = $_GET['employee_introduction_spanish_old'],
        $employee_introduction_french_old = $_GET['employee_introduction_french_old'],
        $employee_experience_old = $_GET['employee_experience_old'],
        $employee_experience_english_old = $_GET['employee_experience_english_old'],
        $employee_experience_spanish_old = $_GET['employee_experience_spanish_old'],
        $employee_experience_french_old = $_GET['employee_experience_french_old'],
        $employee_education_old = $_GET['employee_education_old'],
        $employee_education_english_old = $_GET['employee_education_english_old'],
        $employee_education_spanish_old = $_GET['employee_education_spanish_old'],
        $employee_education_french_old = $_GET['employee_education_french_old']
    );
    $connection->updateInformation($data);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Insurance Calculator</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container" style="margin-top:100px;">
    <?php

    $employeesQueryCommand = $connection->getEmployees();
    echo $connection->updateSuccess;
    ?>
    <div class="row">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead>
            <tr>
                <th scope="col" style="width: 10%">EmployeeID</th>
                <th scope="col">First & Last Name</th>
                <th scope="col">Birthdate</th>
                <th scope="col">SSN</th>
                <th scope="col">Is Employee?</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //FETCH_NUM or FETCH_NAMED can also be used instead of FETCH_BOTH.
            while ($employees = $employeesQueryCommand->fetch(PDO::FETCH_BOTH)){

                $birthdate_manipulated = date('d F Y',strtotime($employees['birthdate']));

                switch ($isEmployee_manipulated = $employees[4]){
                    case 1:
                        $isEmployee_manipulated = "Yes";
                        break;
                    case 0:
                        $isEmployee_manipulated = "No";
                        break;
                }
                echo "
            <tr>
                <th scope=\"row\">{$employees['employeeID']}</th>
                <td>{$employees['name']}</td>
                <td>{$birthdate_manipulated}</td>
                <td>{$employees[3]}</td>
                <td>{$isEmployee_manipulated}</td>
                <td style=\"text-align: center\">
                <i type=\"button\" title='Contact Information' data-toggle=\"modal\" data-target=\"#employeeModal-{$employees['employeeID']}\" class=\"fas fa-info-circle\"></i>
                <i type=\"button\" title='User Edit' data-toggle=\"modal\" data-target=\"#employeeUserModal-{$employees['employeeID']}\" class=\"fas fa-user-edit\"></i>
                </td>
            </tr>";
                echo "<div class=\"modal fade\" id=\"employeeModal-{$employees['employeeID']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Contact Information of {$employees[1]}</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form action=\"index.php\" method='get'>
        <input type='hidden' name='email_old' value='{$employees[5]}'>
        <input type='hidden' name='phone_old' value='{$employees[6]}'>
        <input type='hidden' name='address_old' value='{$employees[7]}'>
          <div class=\"form-group\">
            <label for=\"employee_email\" class=\"col-form-label\">Email:</label>
            <input type='hidden' name='employeeID' value='{$employees['employeeID']}'>
            <input type=\"text\" class=\"form-control\" id=\"employee_email\" name='employee_email' value=\"{$employees[5]}\">
          </div>
          <div class=\"form-group\">
            <label for=\"employee_phone\" class=\"col-form-label\">Phone Number:</label>
            <input type='text' class=\"form-control\" id=\"employee_phone\" name='employee_phone' value='{$employees[6]}'>
          </div>
          <div class=\"form-group\">
            <label for=\"employee_address\" class=\"col-form-label\">Address:</label>
            <textarea class=\"form-control\" id=\"employee_address\" name='employee_address'>{$employees[7]}</textarea>
          </div>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
        <input type=\"submit\" class=\"btn btn-primary\" value='Update' name='submit'>
        </form>
      </div>
    </div>
  </div>
</div>";
                $experienceChecked = $employees[11];

                $educationChecked = $employees[15];

                echo "<div class=\"modal fade\" id=\"employeeUserModal-{$employees['employeeID']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Information of {$employees[1]}</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form action=\"index.php\" method='get'>
        <input type='hidden' name='employee_experience_old' value='{$employees[11]}'>
        <input type='hidden' name='employee_education_old' value='{$employees[15]}'>
          <div class=\"form-group\">
            <label for=\"employee_email\" class=\"col-form-label\">Introduction:</label>
            <ul class=\"nav nav-tabs\" id=\"myTab\" role=\"tablist\">
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link active\" id=\"employee_introduction_english-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_introduction_english{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_introduction_english\" aria-selected=\"true\">English</a>
  </li>
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link\" id=\"employee_introduction_spanish-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_introduction_spanish{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_introduction_spanish\" aria-selected=\"false\">Spanish</a>
  </li>
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link\" id=\"employee_introduction_french-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_introduction_french{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_introduction_french\" aria-selected=\"false\">French</a>
  </li>
</ul>
<div class=\"tab-content\" style='margin-top:10px' id=\"myTabContent\">
            <input type='hidden' name='employeeID' value='{$employees['employeeID']}'>
            <input type='hidden' name='employee_introduction_english_old' value='{$employees[8]}'>
            <input type='hidden' name='employee_introduction_spanish_old' value='{$employees[9]}'>
            <input type='hidden' name='employee_introduction_french_old' value='{$employees[10]}'>
            <textarea class=\"tab-pane fade show active form-control\" aria-labelledby=\"employee_introduction_english-tab{$employees['employeeID']}\" id=\"employee_introduction_english{$employees['employeeID']}\" name='employee_introduction_english' role='tabpanel'>{$employees[8]}</textarea>
            <textarea class=\"tab-pane fade form-control\" aria-labelledby=\"employee_introduction_spanish-tab{$employees['employeeID']}\" id=\"employee_introduction_spanish{$employees['employeeID']}\" name='employee_introduction_spanish' role='tabpanel'>{$employees[9]}</textarea>
            <textarea class=\"tab-pane fade form-control\" aria-labelledby=\"employee_introduction_french-tab{$employees['employeeID']}\" id=\"employee_introduction_french{$employees['employeeID']}\" name='employee_introduction_french' role='tabpanel'>{$employees[10]}</textarea>
            </div>
          </div>
            <label for=\"employee_phone\" class=\"col-form-label\">Job Experience:</label><br>
            <div class='form-check'>
            <input type=\"radio\" class='form-check-input' name=\"employee_experience\" id='employee_experience1' value=\"1\"";

                echo $experienceChecked==1 ? ' checked="checked">' : '>';

                echo "
            <label class=\"form-check-label\" for=\"employee_experience1\">
                Entry Level
            </label>     
            </div>
            <div class='form-check'>
            <input type=\"radio\" class='form-check-input' name=\"employee_experience\" id='employee_experience2' value=\"2\"";

                echo $experienceChecked==2 ? ' checked="checked">' : '>';

                echo "
            <label class=\"form-check-label\" for=\"employee_experience2\">
                Junior Level
            </label>         
            </div>
            <div class='form-check'>
            <input type=\"radio\" class='form-check-input' name=\"employee_experience\" id='employee_experience3' value=\"3\"";

                echo $experienceChecked==3 ? ' checked="checked">' : '>';

                    echo "
            <label class=\"form-check-label\" for=\"employee_experience3\">
                Senior Level
            </label>     
            </div>
            <ul class=\"nav nav-tabs\" id=\"myTab\" style='margin-top: 10px' role=\"tablist\">
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link active\" id=\"employee_experience_english-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_experience_english{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_experience_english\" aria-selected=\"true\">English</a>
  </li>
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link\" id=\"employee_experience_spanish-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_experience_spanish{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_experience_spanish\" aria-selected=\"false\">Spanish</a>
  </li>
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link\" id=\"employee_experience_french-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_experience_french{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_experience_french\" aria-selected=\"false\">French</a>
  </li>
</ul>
<div class=\"tab-content\" style='margin-top:10px' id=\"myTabContent\">
            <input type='hidden' name='employee_experience_english_old' value='{$employees['employee_experience_english']}'>
            <input type='hidden' name='employee_experience_spanish_old' value='{$employees['employee_experience_spanish']}'>
            <input type='hidden' name='employee_experience_french_old' value='{$employees['employee_experience_french']}'>
            <textarea class=\"tab-pane fade show active form-control\" aria-labelledby=\"employee_experience_english-tab{$employees['employeeID']}\" id=\"employee_experience_english{$employees['employeeID']}\" name='employee_experience_english' role='tabpanel'>{$employees['employee_experience_english']}</textarea>
            <textarea class=\"tab-pane fade form-control\" aria-labelledby=\"employee_experience_spanish-tab{$employees['employeeID']}\" id=\"employee_experience_spanish{$employees['employeeID']}\" name='employee_experience_spanish' role='tabpanel'>{$employees['employee_experience_spanish']}</textarea>
            <textarea class=\"tab-pane fade form-control\" aria-labelledby=\"employee_experience_french-tab{$employees['employeeID']}\" id=\"employee_experience_french{$employees['employeeID']}\" name='employee_experience_french' role='tabpanel'>{$employees['employee_experience_french']}</textarea>
            </div>
            <label for=\"employee_phone\" class=\"col-form-label\">Education Information:</label><br>
            <div class='form-check'>
            <input type=\"radio\" class='form-check-input' name=\"employee_education\" id='employee_education1' value=\"1\"";
                echo $educationChecked==1 ? ' checked="checked">' : '>';

                echo "
            <label class=\"form-check-label\" for=\"employee_education1\">
                Bachelor's Level
            </label>     
            </div>
            <div class='form-check'>
            <input type=\"radio\" class='form-check-input' name=\"employee_education\" id='employee_education2' value=\"2\"";
                echo $educationChecked==2 ? ' checked="checked">' : '>';

                echo "
            
            <label class=\"form-check-label\" for=\"employee_education2\">
                Masters Level
            </label>         
            </div>
            <div class='form-check'>
            <input type=\"radio\" class='form-check-input' name=\"employee_education\" id='employee_education3' value=\"3\"";
                echo $educationChecked==3 ? ' checked="checked">' : '>';

                echo "
            
            <label class=\"form-check-label\" for=\"employee_education3\">
                Doctoral Level
            </label>     
            </div>
            <ul class=\"nav nav-tabs\" id=\"myTab\" style='margin-top: 10px' role=\"tablist\">
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link active\" id=\"employee_education_english-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_education_english{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_education_english\" aria-selected=\"true\">English</a>
  </li>
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link\" id=\"employee_education_spanish-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_education_spanish{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_education_spanish\" aria-selected=\"false\">Spanish</a>
  </li>
  <li class=\"nav-item\" role=\"presentation\">
    <a class=\"nav-link\" id=\"employee_education_french-tab{$employees['employeeID']}\" data-toggle=\"tab\" href=\"#employee_education_french{$employees['employeeID']}\" role=\"tab\" aria-controls=\"employee_education_french\" aria-selected=\"false\">French</a>
  </li>
</ul>
<div class=\"tab-content\" style='margin-top:10px' id=\"myTabContent\">
            <input type='hidden' name='employee_education_english_old' value='{$employees['employee_education_english']}'>
            <input type='hidden' name='employee_education_spanish_old' value='{$employees['employee_education_spanish']}'>
            <input type='hidden' name='employee_education_french_old' value='{$employees['employee_education_french']}'>
            <textarea class=\"tab-pane fade show active form-control\" aria-labelledby=\"employee_education_english-tab{$employees['employeeID']}\" id=\"employee_education_english{$employees['employeeID']}\" name='employee_education_english' role='tabpanel'>{$employees['employee_education_english']}</textarea>
            <textarea class=\"tab-pane fade form-control\" aria-labelledby=\"employee_education_spanish-tab{$employees['employeeID']}\" id=\"employee_education_spanish{$employees['employeeID']}\" name='employee_education_spanish' role='tabpanel'>{$employees['employee_education_spanish']}</textarea>
            <textarea class=\"tab-pane fade form-control\" aria-labelledby=\"employee_education_french-tab{$employees['employeeID']}\" id=\"employee_education_french{$employees['employeeID']}\" name='employee_education_french' role='tabpanel'>{$employees['employee_education_french']}</textarea>
            </div>
          </div>
          
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
        <input type=\"submit\" class=\"btn btn-primary\" value='Update' name='update'>
        </form>
      </div>
    </div>
  </div>
</div>";
            }
            ?>

            </tbody>
        </table>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/02266269af.js" crossorigin="anonymous"></script>

<script>
    window.setTimeout(function() {
        $("#mainAlertMessage").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 1500);
</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>