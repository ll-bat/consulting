<?php

namespace App\Helperclass;

use App\Control;

class RiskCalculator {

    private $result = [];
    private $reducesPotentialLoss = false;

    public function __construct($k, $obj){
        $this->calculate(dval($k), $obj);
    }

    public function calculate($k, $obj){
        $this->calcFirstResult($k, $obj);
        $this->calcFirstProbability($k, $obj);
        $this->calcFirstLevel();
        $this->calcSecondResult();
        $this->calcSecondProbability();
        $this->calcSecondLevel();
    }

    public function calcFirstResult($k, $obj){
        $mx = 0;
        $test = [];
        foreach ($obj['ploss'] as $p){
            $mx = max($mx, dval($p['model']['k']));
            $test[] = dval($p['model']['k']);
        }

        $result = round($mx * $k);
        if ($result > 5) $result = 5;
        elseif ($result < 1) $result = 1;

        $test[] = $k;
        $test[] = $result;

        $this->result['first_result'] = $result;
        // dd($test);
    }

    public function calcFirstProbability($k, $obj){
        $userControlsSum = 0;
        $test = [];
        foreach ($obj['control'][0] as $c){
            $userControlsSum += dval($c['model']['k']);
            $test['userControlsK'][] = dval($c['model']['k']);
        }

        foreach ($obj['control'][1] as $c){
            if ($c['model']['rploss'] == 1){
                $this->reducesPotentialLoss = true;
                break;
            }
        }

        $allControlsSum = $obj['dangerControlsSum'];

        $percent = ($userControlsSum / $allControlsSum) * 100;
        $test['percent'] = $percent;

        $types = [20 => 5,40 => 4,60 => 3, 80 => 2, 101 => 1];

        $result = -1;
        foreach ($types as $type => $val){
             if ($percent >= $type) continue;
             $result = $val;
             break;
        }

        if ($result == -1) $result = 1;

        $test['result'] = $result;

        $this->result['first_probability'] = $result;

        // dd($test);
    }

    public function calcFirstLevel(){
        $this->result['first_level'] = $this->result['first_result'] * $this->result['first_probability'];
        // dd($this->result['first_level']);
    }

    public function calcSecondResult(){
        $this->result['second_result'] = $this->result['first_result'];
        if ($this->reducesPotentialLoss && $this->result['second_result'] > 1) $this->result['second_result']--;
        // dd($this->reducesPotentialLoss);
    }

    public function calcSecondProbability() {
        $this->result['second_probability'] = $this->result['first_probability'];
    }

    public function calcSecondLevel(){
        $this->result['second_level'] = $this->result['second_result'] * $this->result['second_probability'];
    }

    public function getResult(){
        return $this->result;
    }


}



