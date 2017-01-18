<?php

namespace App\Http\Controllers;

use App\Player;

class RateController extends Controller
{
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
