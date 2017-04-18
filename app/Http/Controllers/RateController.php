<?php

namespace App\Http\Controllers;

use App\Player;
use Carbon\Carbon;

class RateController extends Controller
{
    public function __construct()
    {
        if( ($res = self::check_launch()) != false) return $res;
    }

    public static function check_launch()
    {
//        $open = Carbon::create(2017, 01, 28);
//        $close = Carbon::create(2018, 01, 28);
//        if(! Carbon::now()->between($open, $close))
//            return redirect()->route('coming_soon');
        return false;
    }

    public function vote($winner)
    {
        session_start();
        if(!isset($_SESSION['player_1']) && !isset($_SESSION['player_2'])) return 'invalid request';

        $player_1 = Player::find($_SESSION['player_1']);
        $player_2 = Player::find($_SESSION['player_2']);

        if($winner == 'left'){
            $player_1_E = $this->expected($player_2->score, $player_1->score);
            $player_2_E = $this->expected($player_1->score, $player_2->score);
            $player_1->score = $this->win($player_1->score, $player_1_E);
            $player_2->score = $this->loss($player_2->score, $player_2_E);
        }else if($winner == 'right'){
            $player_2_E = $this->expected($player_1->score, $player_2->score);
            $player_1_E = $this->expected($player_2->score, $player_1->score);
            $player_2->score = $this->win($player_2->score, $player_2_E);
            $player_1->score = $this->loss($player_1->score, $player_1_E);
        }else return 'invalid request';

        $player_1->save();
        $player_2->save();

        unset($_SESSION['player_1']);
        unset($_SESSION['player_2']);

        header('x-team: '.stripos($_SERVER['HTTP_REFERER'], 'mansiverma'));

        return redirect()->route('home');
    }

    public function expected($Rb, $Ra) {
        return 1/(1 + pow(10, ($Rb-$Ra)/400));
    }

    public function win($score, $expected, $k = 1) {
        return $score + $k * (1-$expected);
    }

    public function loss($score, $expected, $k = 1) {
        return $score + $k * (0-$expected);
    }

}
