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
    function add(){
        $fractions = func_get_args();
        $fractions_count = count($fractions);
        
        // calculate the common denominator
        $denominator = $fractions[0]->getDenominator();
        for($i = 1; $i < $fractions_count; ++$i){
            $denominator = self::lcm($denominator, $fractions[$i]->getDenominator());
        }
        
        // add up all the adjusted numerators
        $numerator = 0;
        foreach($fractions as $k => $v){
            $numerator += $fractions[$k]->getNumerator() * ($denominator / $fractions[$k]->getDenominator());
        }
        
        return new Fraction($numerator, $denominator);
    }   

    // convert a Fraction object to a pretty string
    public function toString($fraction, $mixed=true, $lowest_terms=true){
        $whole = 0;
        $numerator = $fraction->getNumerator();
        $denominator = $fraction->getDenominator();

        if($mixed){
            $fraction_array = self::toMixed($fraction);
            $whole = $fraction_array[0];
            $numerator = $fraction_array[1];
            $denominator = $fraction_array[2];
            $fraction = new Fraction($numerator, $denominator);
        }

        if($lowest_terms){
            $fraction = self::toLowestTerms($fraction);
            $numerator = $fraction->getNumerator();
            $denominator = $fraction->getDenominator();
        }

        // don't need to show leading zero
        if($whole == 0){
            $whole = '';
        // append space after the whole number since we don't want the whole and numerator touching
        } else {
            $whole .= " ";
        }

        // don't show the numerator or denominator
        if($numerator == 0){
            $numerator = '';
            $denominator = '';
        // append a slash after the numerator
        } else {
            $numerator .= "/";
        }

        // if the fraction is just zero, just show a zero
        if($whole == 0 && $numerator == 0){
            return 0;
        } else {
            $fraction_str = $whole . $numerator . $denominator;
            return trim($fraction_str);
        }
    }
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

    // convert an array to a Fraction object
    // valid formats: array(whole), array(numerator, denominator), array(whole, numerator, denominator) 
    public function fromArray($fraction_array){
        $fraction_array_count = count($fraction_array);
        // there is just a whole part
        if($fraction_array_count == 1){
            $fraction = new Fraction($fraction_array[0], 1);
        // there is a numerator and denominator
        } else if($fraction_array_count == 2){
            $fraction = new Fraction($fraction_array[0], $fraction_array[1]);
        // fraction with whole part, numerator and denominator, just run through toImproper()
        } else if($fraction_array_count == 3) {
            $fraction = self::toImproper($fraction_array);
        } else {
            throw new RuntimeException('Expected an array of length 1, 2 or 3 but got one of length ' . $fraction_array_count);
        }

        return $fraction;
    }

    // converts a Fraction object into an array representing the fraction as a mixed number (array[0] = whole, array[1] = numerator, array[2] = denominator)
    public function toMixed($fraction){
        $numerator = $fraction->getNumerator();
        $whole = 0;
        // we only need to do something if the numerator is greater than the denominator 
        if(abs($fraction->getNumerator()) >= $fraction->getDenominator()) 
        {
            // gotta use two different functions because of the negative issue
            if($fraction->getNumerator() > 0){
                $whole = floor($fraction->getNumerator() / $fraction->getDenominator());    
            } else { 
                $whole = ceil($fraction->getNumerator() / $fraction->getDenominator()); 
            }
            
            // recalculate the numerator
            $numerator = $numerator - ($whole * $fraction->getDenominator()); 
            // the negative sign will be on the whole part, so get rid of it on the numerator
            if($fraction->getNumerator() < 0){
                $numerator *= -1;
            }
        } 
        
        return array($whole, $numerator, $fraction->getDenominator());
    }

    // convert a Fraction object to lowest terms
    public function toLowestTerms($fraction){
        $gcf = self::gcf($fraction->getNumerator(), $fraction->getDenominator());
        return new Fraction($fraction->getNumerator() / $gcf, $fraction->getDenominator() / $gcf);
    }

    // return the greatest common factor of a and b
    private function gcf($a, $b){
        while($b != 0){
            $tmp = $a;
            $a = $b;
            $b = $tmp % $b;
        }
        return $a;
    }

    // returns the least common multiple of two integers
    function lcm($a, $b){
        $a = abs($a);
        $b = abs($b);
        return $a * $b / self::gcf($a, $b);
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
