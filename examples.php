<?php
include 'fractions.php';
// Create a basic fraction
$a = new Fraction(1,2);
// Because the Fraction constructor only accepts a numerator, and denominator, you can use this method to convert a mixed number to a Fraction object 
$b = Fractions::fromArray(array(1,1,2)); 
// The denominator is assumed to be 1 if none is given
$c = new Fraction(5);
// Convert a well formed string to a fraction
$d = Fractions::fromString("-1 2/3");
$e = Fractions::fromString("8/10");

$sum = Fractions::add($a, $b); 
// Fraction::toString() is dumb, and just prints the numerator/denominator
echo $sum->toString(), "\n"; // 4/2
// Fractions::toString() prints in lowest terms, and mixed numbers
echo Fractions::toString($sum), "\n"; // 2

$diff = Fractions::subtract($c, $b, $e);
echo Fractions::toString($diff), "\n";

$prod = Fractions::multiply($c, $b, $e);
echo Fractions::toString($prod), "\n";

$quo = Fractions::divide($c, $b, $e);
// Don't convert to a mixed number with the Fractions::toString method
echo Fractions::toString($quo, false), "\n";
// Don't convert to a mixed number, or convert to lowest terms
echo Fractions::toString($quo, false, false), "\n";
?>
