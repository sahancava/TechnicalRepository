<?

class Calculator {

    public $NumberOfInstalments;
    public $TaxAmount;

    function __construct()
    {
        if (isset($_POST["submit"])){
            $this->NumberOfInstalments=$_POST["NumberOfInstalments"];
            $this->TaxAmount=$_POST["TaxPercentage"];
        }
    }

    function setEstimatedValue($value){
        $this->name=$value;
    }

    function getEstimatedValue(){
        return htmlspecialchars($this->name);
    }

    function getBasePriceOfThePolicy(){
        $rate = 0.11;
        $premiumRate = 0.13;

        if(date("D")==="Fri" && date("H")>=15 && date("H")<=20){
            return $this->decimalize(($this->getEstimatedValue()*$premiumRate));
        }
        return $this->decimalize(($this->getEstimatedValue()*$rate/$this->NumberOfInstalments));
    }

    function getCommissionAmount(){
        return $this->decimalize(($this->getBasePriceOfThePolicy()*0.17));
    }

    function getTax(){
        return $this->decimalize(($this->getBasePriceOfThePolicy()*$this->TaxAmount/100));
    }

    function getSum(){
        $tax = (int)$this->getTax();
        $commission = (int)$this->getCommissionAmount();
        $basePrice = (int)$this->getBasePriceOfThePolicy();
        return $this->decimalize($tax+$commission+$basePrice);
    }

    function decimalize($item){
        return number_format($item,2,'.','');
    }
}

