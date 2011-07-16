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

class Fractions {       
    // converts a string into a Fraction object
    public function fromString($fraction_str){
        // if the fraction is numeric, that means there is just a whole part
        if(is_numeric($fraction_str)){
            $fraction = new Fraction($fraction_str, 1);
        } else {
            // split the fraction on the slash
            $part1 = explode('/', $fraction_str);
            if(count($part1) == 1){
                throw new RuntimeException('Expected a slash '/' in the fraction string but it is not present');
            }
            
            // split the fraction on the space (for mixed numbers)
            $part2 = preg_split('/\s+/', $part1[0]);

            // we have a whole number in the fraction
            if(count($part2) == 2){ 
                $fraction_parts = array($part2[0], $part2[1], $part1[1]);   
            } else {
                $fraction_parts = array(0, $part1[0], $part1[1]);   
            }
                    
            // make it improper since a Fraction object only has a denominator and numerator
            $fraction = self::toImproper($fraction_parts);
        }
        
        return $fraction;
    }

    // converts a 3 element array (where array[0] = whole, array[1] = numerator, and array[2] = denominator) into a Fraction object
    // or a 2 element array (where array[0] = numerator, and array[1] = denominator)
    private function toImproper($fraction_parts){
        // if there is a whole part to the fraction, do the math
        if(count($fraction_parts) == 3){
            $whole = $fraction_parts[0];
            $numerator = $fraction_parts[1];
            $denominator = $fraction_parts[2];
            // calculate the new numerator using the math you used in middle school
            $new_numerator = abs($denominator) * abs($whole) + abs($numerator);
            // figure out the sign of the numerator (special case if $whole == 0)
            if(($whole == 0 && $denominator * $numerator < 0) || ($whole * $numerator * $denominator < 0)){
                $sign = -1;
            } else {
                $sign = 1;
            }
            $fraction = new Fraction($sign * $new_numerator, abs($denominator));
        } else { 
            $fraction = new Fraction($fraction_parts[0], $fraction_parts[1]);
        }
        
        return $fraction;
    }   
}
?>
