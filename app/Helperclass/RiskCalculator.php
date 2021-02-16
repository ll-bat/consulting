<?php

namespace App\Helperclass;

use App\Control;

class RiskCalculator
{

    private $result = [];
    private $reducesPotentialLoss = false;

    /**
     * $k is the current danger's k
     * $obj includes [ploss, controls, sumOfAllControlsInDanger]
     *
     * RiskCalculator constructor.
     * @param $k
     * @param $obj
     */
    public function __construct($k, $obj)
    {
        $this->calculate(dval($k), $obj);
    }

    /**
     * Do risk's calculation
     *
     * @param $k
     * @param $obj
     */
    public function calculate($k, $obj)
    {
        $this->calcFirstResult($k, $obj);
        $this->calcFirstProbability($k, $obj);
        $this->calcFirstLevel();
        /**
         * calcFirstResult calculates second[result, probability] as well, due to some calculated var..
         */
        $this->calcSecondLevel();
    }

    /**
     * Danger k is multiplied by the max value found among the checked potentialLosses' k.
     *
     * @param $k
     * @param $obj
     */
    public function calcFirstResult($k, $obj)
    {
        $mx = 0;
        foreach ($obj['ploss'] as $p) {
            $mx = max($mx, dval($p['model']['k']));
        }

        $result = round($mx * $k);
        if ($result > 5) $result = 5;
        elseif ($result < 1) $result = 1;

        $this->result['first_result'] = $result;
    }

    public function calcFirstProbability($k, $obj)
    {
        $firstControlsSum = 0;
        $secondControlsSum = 0;
        $addedControlsSum = 0;

        /**
         * Calculate [first] type controls sum and $addedControls as well.
         */
        foreach ($obj['control'][0] as $c) {
            $k = dval($c['model']['k']);

            $firstControlsSum += $k;
            if (isset($c['added'])) {
                $addedControlsSum += $k;
            }
        }

        /**
         * Calculate $secondControlsSum and find if any of the chosen potentialLosses has 'rploss' checked.
         */

        foreach ($obj['control'][1] as $c) {
            $k = dval($c['model']['k']);

            $secondControlsSum += $k;

            if (isset($c['added'])) {
                $addedControlsSum += $k;
            }

            if ($c['model']['rploss'] == 1) {
                $this->reducesPotentialLoss = true;
            }
        }

        /**
         * all controls some;
         */
        $allControlsSum = $obj['dangerControlsSum'] + $addedControlsSum;

        /**
         * percent of the [first] controls type;
         */
        $percent = ($firstControlsSum / $allControlsSum) * 100;

        /**
         * small diagram like structure which gives us a 'score' according to percent;
         */
        $scores = [10 => 5, 30 => 4, 50 => 3, 70 => 2, 101 => 1];

        /**
         * For easy understandings, let's simulate the score calculation process.
         * Say our percent is 30, then we have:
         * Iteration one: $currentPercent = 10, $score = 5    -> omit this element;
         * Iteration two: $currentPercent = 30, $score = 4    -> still omit this element, because score 3 is given to those having probability in range [30, 49.9];
         * Iteration three: $currentPercent = 50, $score = 3  -> This time, comparison returns false, so we get score - 3;
         *
         * This piece of code is needed for calculating second_result as well
         * Therefore, we create a function which accepts one - $percent - argument, and returns - $score
         *
         * @param $ourPercent
         * @return int
         */

        $getScore = function($ourPercent) use($scores) {
            $result = -1;
            foreach ($scores as $currentPercent => $score) {
                if ($ourPercent >= $currentPercent) continue;
                $result = $score;
                break;
            }

            if ($result < 1) {
                $result = 1;

                /**
                 * TODO: Log error. Something does not work properly.
                 */
            }

            return $result;
        };

        /**
         * We now have first probability.
         */
        $this->result['first_probability'] = $getScore($percent);


        /**
         * This time we should work on second[result, level] calculation
         * We can do the rest in another function, but
         * variables are already calculated, so we can actually calculate them.
         */

        /**
         * First, calculate new percent
         */
        $percent = ( ($firstControlsSum + $secondControlsSum) / $allControlsSum ) * 100;

        /**
         * Scores are the same, so we keep them.
         * Use $getScore function to calculate [secondProbability];
         */

        $this->result['second_probability'] = $getScore($percent);

        /**
         * Extra risk's result is almost same as [first] risk's result,
         * the only difference is that, this one reduces by 1, if any of the potentialLosses has checked - 'Reduces potential loss'
         */

        $this->result['second_result'] = $this->result['first_result'];
        if ($this->reducesPotentialLoss && $this->result['second_result'] > 1) {
            $this->result['second_result']--;
        }

    }

    public function calcFirstLevel()
    {
        $this->result['first_level'] = $this->result['first_result'] * $this->result['first_probability'];
    }


    public function calcSecondLevel()
    {
        $this->result['second_level'] = $this->result['second_result'] * $this->result['second_probability'];
    }

    /**
     * Returns calculated risks.
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }


}



