<?php
require_once (__DIR__ . '/insuranceCalculator.php');
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
    <div class="row">
        <div class="col-lg-6" style="float:none;margin: auto;">
            <form method="GET" action="index.php">
                <div class="form-group">
                    <label for="EstimatedValue">Estimated Value (between 100 and 100.000 EUR)</label>
                    <input type="number" class="form-control" id="EstimatedValue" name="EstimatedValue" min="100" max="100000">
                </div>
                <div class="form-group">
                    <label for="TaxPercentage">Tax Percentage (between 0 and 100)</label>
                    <input type="number" class="form-control" id="TaxPercentage" name="TaxPercentage" min="0" max="100" value="0">
                </div>
                <div class="form-group">
                    <label for="NumberOfInstalments">Number of Instalments (between 1 and 12)</label>
                    <select class="custom-select my-1 mr-sm-2" id="NumberOfInstalments" name="NumberOfInstalments">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <input name="submit" type="submit" value="Calculate" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>
    <?php

    if(isset($_POST["submit"])){

        $Calculator = new Calculator();

        $EstimatedValue = $_POST["EstimatedValue"];

        $Calculator->setEstimatedValue($EstimatedValue);

        $BasePriceOfThePolicy = $Calculator->getBasePriceOfThePolicy();
        $AmountOfCommission = $Calculator->getCommissionAmount();
        $TaxAmount = $Calculator->getTax();
        $sum = $Calculator->getSum();

        echo "<div class=\"row\" style='margin-top: 50px'>";
        echo "<table class=\"table table-striped table-bordered\">
  <thead>
    <tr>
    <th>Instalment #</th>
    <th>Base Value</th>
    <th>Amount of Commission</th>
    <th>Amount of Tax</th>
    <th>Total Amount</th>
    </tr>
    </thead><tbody>";

        for ($i =1;$i<=$Calculator->NumberOfInstalments;$i++){
            echo "
    <tr>
      <th scope=\"row\">$i</th>
      <th>$BasePriceOfThePolicy</th>
      <th>$AmountOfCommission</th>
      <th>$TaxAmount</th>
      <th>$sum</th>
      </tr>
      ";
        }
        echo "<tfoot id='someclass'></tfoot>";
        echo "</tbody></table></div>";
        echo "</div>";
    }
    ?>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    document.getElementById("someclass").innerHTML="<tr>" +
        "<th scope=\"row\">Total Amount</th>" +
        "<th><?=number_format($BasePriceOfThePolicy*$Calculator->NumberOfInstalments,2,'.','')?></th>" +
        "<th><?=number_format($AmountOfCommission*$Calculator->NumberOfInstalments,2,'.','')?></th>" +
        "<th><?=number_format($TaxAmount*$Calculator->NumberOfInstalments,2,'.','')?></th>" +
        "<th><?=number_format($sum*$Calculator->NumberOfInstalments,2,'.','')?></th>" +
        "</tr>";
</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>