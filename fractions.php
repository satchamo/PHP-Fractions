<?php
/* A fraction object has a numerator and denominator. It is immutable. */
class Fraction {
    private $numerator;
    private $denominator;

    public function __construct($numerator, $denominator = 1){
        // keep the negative sign on the numerator
        if($denominator < 0){
            $numerator *= -1;
            $denominator *= -1;
        }

        $this->numerator = $numerator;
        $this->denominator = $denominator;
    }

    public function getNumerator(){ return $this->numerator; }
    public function getDenominator(){ return $this->denominator; }
    public function toString(){ return $this->numerator . "/" . $this->denominator; }
}
?>
