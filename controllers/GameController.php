<?php

namespace Controllers;

class GameController{
    
    public static function index(){

        require_once ROOT ."/views/roulette.php";
        require_once ROOT ."/templates/global.php";
    }

    public static function play(){
        $symbols_with_weights = [
            '🍋' => 40,
            '🍒' => 30,
            '⭐' => 15,
            '🔔' => 10,
            '💎' => 5,
        ];

        $paytable = [
            '🍋🍋🍋' => 40,
            '🍒🍒🍒' => 50,
            '⭐⭐⭐' => 100,
            '🔔🔔🔔' => 150,
            '💎💎💎' => 200,
        ];

        $reel1 = self::getRandomSymbol($symbols_with_weights);
        $reel2 = self::getRandomSymbol($symbols_with_weights);
        $reel3 = self::getRandomSymbol($symbols_with_weights);

        $combination = $reel1 .$reel2 . $reel3;

        $gain = $paytable[$combination] ?? 0;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'reels' => [$reel1, $reel2, $reel3],
            'gain' => $gain, 
        ]);
    }

    private static function getRandomSymbol($symbols_with_weights){
        $rand = mt_rand(1, array_sum($symbols_with_weights));

        foreach ($symbols_with_weights as $symbol => $weight) {
            if ($rand <= $weight) {
                return $symbol;
            }

            $rand -= $weight;
        }

        return null;
    }
}