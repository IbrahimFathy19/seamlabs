<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

define("ALPHABETICAL_CHARACTERS_COUNT", 26);

class ProblemController extends Controller
{

    private function count1($end)
    {

        // Base cases (Assuming n is not negative)
        if ($end < 5)
            return $end;
        if ($end >= 5 && $end < 10)
            return $end - 1;

        // Calculate 10^(d-1) (10 raise to the
        // power d-1) where d is number of digits
        // in n. po will be 100 for n = 578
        $po = 1;
        for ($x = intval($end / $po); $x > 9; $x = intval($end / $po))
            $po = $po * 10;

        // find the most significant digit (msd is 5 for 578)
        $msd = intval($end / $po);

        if ($msd != 5)

            // For 578, total will be 4*count(10^2 - 1)
            // + 4 + count(78)
            return $this->count1($msd) * $this->count1($po - 1) +
                $this->count1($msd) + $this->count1($end % $po);
        else
            // For 35, total will be equal to count(29)
            return $this->count1($msd * $po - 1);
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
        // $count = $this->count1($end);

        /** O(n) solution */
        $count = 0;
        for ($i = $start; $i <= $end; $i++) {
            if (strpos($i, "5") === false) {
                $count++;
            }
        }


        return $this->handleResponse([
            'count' => $count
        ]);
    }

    private function has5(int $value)
    {
        return $value > 0 && ($value % 10 == 5 || $this->has5($value / 10));
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
