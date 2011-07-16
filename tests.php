<?php
include 'fractions.php';
/* I should probably use a unit testing framework... */
function assertEqual($a, $b, $test){
    if($a == $b){
        echo "PASS: " . $test;
    } else {
        echo "*****FAIL: " . $test;
    }
    echo "\n";
}

//****************************
//* Fraction::getNumerator() *
//****************************
$f = new Fraction(1,-2);
$test = "Fraction(1,-2)->getNumerator()";
assertEqual($f->getNumerator(), "-1", $test);

$f = new Fraction(10,2);
$test = "Fraction(10,2)->getNumerator()";
assertEqual($f->getNumerator(), "10", $test);

$f = new Fraction(-3,-4);
$test = "Fraction(-3,-4)->getNumerator()";
assertEqual($f->getNumerator(), "3", $test);

//******************************
//* Fraction::getDenominator() *
//******************************
$f = new Fraction(1,-2);
$test = "Fraction(1,-2)->getDenominator()";
assertEqual($f->getDenominator(), "2", $test);

$f = new Fraction(10,2);
$test = "Fraction(10,2)->getDenominator()";
assertEqual($f->getDenominator(), "2", $test);

$f = new Fraction(-3,-4);
$test = "Fraction(-3,-4)->getDenominator()";
assertEqual($f->getDenominator(), "4", $test);

//************************
//* Fraction::toString() *
//************************
$f = new Fraction(1,-2);
$test = "Fraction(1,-2)->toString()";
assertEqual($f->toString(), "-1/2", $test);

$f = new Fraction(10,2);
$test = "Fraction(10,2)->toString()";
assertEqual($f->toString(), "10/2", $test);

$f = new Fraction(-3,-4);
$test = "Fraction(-3,-4)->toString()";
assertEqual($f->toString(), "3/4", $test);
?>
