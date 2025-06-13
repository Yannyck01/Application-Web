<?php
declare(strict_types=1);


namespace Entity\form;

use Entity\Exception\EntityNotFoundException;
use Entity\Game;

class GameForm
{
    private ?Game $game;

    /**
     * @param Game|null $game
     */
    public function __construct(?Game $game)
    {
        $this->game = $game;
    }


    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }




}