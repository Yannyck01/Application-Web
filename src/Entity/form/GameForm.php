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

    public function getHtmlForm(string $action): string
    {
        return <<<HTML
        <form name="gameForm"  action="$action" method="POST">
            <div class="container">
                <h1>Création d'un nouveau jeu</h1>
                <label>
                    <input name="game__name" type="text" placeholder="Game Name" value="{$this->game->getName()}">
                </label>
                <label>
                    <input name="id" type="hidden" placeholder="ID" value="{$this->game?->getId()}">
                </label>
                <label>
                    <input name="desc" type="text" placeholder="Description" value="{$this->game->getShortDescription()}">
                </label>
                <label>
                    <input name="price__euro" type="number" placeholder="price in euro" value="{$this->game->getPrice()}">
                </label>
                <label>
                    <input name="grade__100" type="number" placeholder="Grade out of 100" value="{$this->game->getMetacritic()}">
                </label>
            </div>
        </form>

    HTML;

    }


    public function setFromQueryString(): void
    {
        if(isset($_POST['id']) && is_numeric($_POST['id'])){
            $id = (int) $_POST['id'];
        }
        else {
            $id = null;
        }

        if(empty($_POST['game__name'])) {
            throw new EntityNotFoundException(("Le nom ne correspond à aucun jeu"));
        }

        if(empty($_POST['desc'])) {
            throw new EntityNotFoundException(("La description ne correspond à aucun jeu"));
        }

        if(isset($_POST['price__euro']) && is_numeric($_POST['price__euro'])){
            $price = (int) $_POST['price__euro'];
        }
        else {
            $price = null;
        }

        if(isset($_POST['grade__100']) && is_numeric($_POST['grade__100'])){
            $grade = (int) $_POST['grade__100'];
        }
        else {
            $grade = null;
        }


        $this->game = (new Game)->create();

    }



}