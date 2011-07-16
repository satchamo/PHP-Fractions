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

//************************
//* Fraction::fromString() *
//************************
$f = "1/2";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "1/2", $test);

$f = "-5/2";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "-5/2", $test);

$f = "5/-2";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "-5/2", $test);

$f = "1 2/3";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "5/3", $test);

$f = "-1 2/3";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "-5/3", $test);

$f = "1 -2/3";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "-5/3", $test);

$f = "1 -2/-3";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "5/3", $test);

$f = "-1 -2/-3";
$test = "Fractions::fromString('$f')";
assertEqual(Fractions::fromString($f)->toString(), "-5/3", $test);

//**************************
//* Fractions::fromArray() *
//**************************
$f = array(3);
$test = "Fractions::fromArray(array(3))";
assertEqual(Fractions::fromArray($f)->toString(), "3/1", $test);

$f = array(1,3);
$test = "Fractions::fromArray(array(1,3))";
assertEqual(Fractions::fromArray($f)->toString(), "1/3", $test);

$f = array(1,2,3);
$test = "Fractions::fromArray(array(1,2,3))";
assertEqual(Fractions::fromArray($f)->toString(), "5/3", $test);

//************************
//* Fractions::toMixed() *
//************************
$f = new Fraction(5,3);
$test = "Fractions::toMixed(Fraction(5,3))";
assertEqual(Fractions::toMixed($f), array(1,2,3), $test);

$f = new Fraction(-5,3);
$test = "Fractions::toMixed(Fraction(-5,3))";
assertEqual(Fractions::toMixed($f), array(-1,2,3), $test);

$f = new Fraction(-10,2);
$test = "Fractions::toMixed(Fraction(-10,2))";
assertEqual(Fractions::toMixed($f), array(-5,0,2), $test);

$f = new Fraction(10,2);
$test = "Fractions::toMixed(Fraction(10,2))";
assertEqual(Fractions::toMixed($f), array(5,0,2), $test);

$f = new Fraction(1,3);
$test = "Fractions::toMixed(Fraction(1,3))";
assertEqual(Fractions::toMixed($f), array(0,1,3), $test);

//******************************
//* Fractions::toLowestTerms() *
//******************************
$f = new Fraction(10,2);
$test = "Fractions::toLowestTerms(Fraction(10,2))";
assertEqual(Fractions::toLowestTerms($f)->toString(), "5/1", $test);

$f = new Fraction(-20,5);
$test = "Fractions::toLowestTerms(Fraction(-20,5))";
assertEqual(Fractions::toLowestTerms($f)->toString(), "-4/1", $test);

$f = new Fraction(0,4);
$test = "Fractions::toLowestTerms(Fraction(0,4))";
assertEqual(Fractions::toLowestTerms($f)->toString(), "0/1", $test);

//*************************
//* Fractions::toString() *
//*************************
$f = new Fraction(0,4);
$test = "Fractions::toString(Fraction(0,4))";
assertEqual(Fractions::toString($f), "0", $test);

$f = new Fraction(1,4);
$test = "Fractions::toString(Fraction(1,4))";
assertEqual(Fractions::toString($f), "1/4", $test);

$f = new Fraction(9,4);
$test = "Fractions::toString(Fraction(9,4))";
assertEqual(Fractions::toString($f), "2 1/4", $test);

$f = new Fraction(-9,4);
$test = "Fractions::toString(Fraction(-9,4))";
assertEqual(Fractions::toString($f), "-2 1/4", $test);

$f = new Fraction(-10,4);
$test = "Fractions::toString(Fraction(-10,4), false)";
assertEqual(Fractions::toString($f, false), "-5/2", $test);

$f = new Fraction(-10,4);
$test = "Fractions::toString(Fraction(-10,4),true,false)";
assertEqual(Fractions::toString($f,true,false), "-2 2/4", $test);

$f = new Fraction(-10,4);
$test = "Fractions::toString(Fraction(-10,4),false,false)";
assertEqual(Fractions::toString($f,false,false), "-10/4", $test);

$f = new Fraction(8,4);
$test = "Fractions::toString(Fraction(8,4))";
assertEqual(Fractions::toString($f), "2", $test);
echo Fractions::toString($f);
?>
