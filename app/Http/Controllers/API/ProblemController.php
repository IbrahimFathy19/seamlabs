<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

define("ALPHABETICAL_CHARACTERS_COUNT", 26);

class ProblemController extends Controller
{
    private function _count($n)
    {
        // Base cases (Assuming n is not negative)
        if ($n < 5)
            return $n;
        if ($n >= 5 && $n < 10)
            return $n - 1;

        $power = 1;
        for ($x = intval($n / $power); $x > 9; $x = intval($n / $power)) {
            $power = $power * 10;
        }

        $mostSignificantDigit = intval($n / $power);

        if ($mostSignificantDigit == 5) {
            return $this->_count($mostSignificantDigit * $power - 1);
        } else {
            $mostSignificantDigitCount = $this->_count($mostSignificantDigit);
            return $mostSignificantDigitCount * $this->_count($power - 1) +
                $mostSignificantDigitCount + $this->_count($n % $power);
        }
    }

    public function problem_1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|integer',
            'end' => 'required|integer|gte:start',
        ]);
        if ($validator->fails()) {
            return $this->handleValidationError($validator->errors());
        }

        $start = $validator->validated()['start'];
        $end = $validator->validated()['end'];

        // /** O(log n) solution */
        $endCount = $end < 0 ? $this->_count(abs($end)) * -1 : $this->_count(abs($end)) * 1; // 1 - end
        $startCount = $start < 0 ? $this->_count(abs($start)) * -1 : $this->_count(abs($start)) * 1; // 1 - start
        $count = $endCount - $startCount + 1;

        // /** O(n) solution */
        // $count = 0;
        // for ($i = $start; $i <= $end; $i++) {
        //     if (strpos($i, "5") === false) {
        //         $count++;
        //     }
        // }

        return $this->handleResponse([
            'count' => $count
        ]);
    }

    private function base26ToDecimal(string $n)
    {
        $dec_value = 0;
        $n_length = strlen($n);
        // Initializing base value to 1, i.e 26^0
        $base = 1;
        for ($i = $n_length - 1; $i >= 0; $i--) {
            $last_digit = ord($n[$i]) - 64;
            $dec_value += $last_digit * $base;
            $base = $base * 26;
        }
        return $dec_value;
    }

    public function problem_2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_string' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->handleValidationError($validator->errors());
        }

        $str = $validator->validated()['input_string'];

        $sum = $this->base26ToDecimal($str);

        /** O(log n) */
        // $sum = 0;
        // $str_length = strlen($str);
        // for ($i = 0; $i < $str_length; $i++) {
        //     $sum += (ord($str[$i]) - 64) * pow(ALPHABETICAL_CHARACTERS_COUNT, $str_length - 1 - $i);
        // }

        return $this->handleResponse([
            'sum' => $sum
        ]);
    }

    public function problem_3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q_array' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->handleValidationError($validator->errors());
        }

        $arr = $validator->validated()['q_array'];
        $result = [];
        foreach ($arr as $x) {
            $counter = 0;
            while ($x !== 0) {
                // find minimum numbers that give minimum sum
                $a = (int)ceil(sqrt($x));
                $b = (int)($x / $a);

                if ($a !== 1 && $b !== 1) {
                    $x = max($a, $b);
                } else {
                    $x--;
                }
                $counter++;
            }
            array_push($result, $counter);
        }
        return $this->handleResponse([
            'result' => $result
        ]);
    }
}
