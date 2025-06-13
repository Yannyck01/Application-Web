<?php
declare(strict_types=1);


namespace Entity\form;

use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Exception\ParameterException;

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
        <div class="header">
            <h1>Création d'un nouveau jeu</h1>
        </div>
        <form name="gameForm"  action="$action" method="POST">
            <div class="container">
                <h1></h1>
                <label>
                    <input name="name" type="text" placeholder="Nom" value="{$this->game?->getName()}">
                </label>
                <label>
                    <input name="id" type="hidden" placeholder="ID" value="{$this->game?->getId()}">
                </label>
                <label>
                    <input name="desc" type="text" placeholder="Description" value="{$this->game?->getShortDescription()}">
                </label>
                <label>
                    <input name="price" type="number" placeholder="Prix" value="{$this->game?->getPrice()}">
                </label>
                <label>
                    <input name="grade" type="number" placeholder="Note sur 100" value="{$this->game?->getMetacritic()}">
                </label>
                <label>
                    <input name="posterId" type="number" placeholder="Id Poster" value="{$this->game?->getPosterId()}">
                </label>
                <label>
                    <input name="devId" type="number" placeholder="Id Développeur" value="{$this->game?->getDeveloperId()}">
                </label>
                <label>
                    <input name="mac" type="number" placeholder="Mac" value="{$this->game?->getMac()}">
                </label>
                <label>
                    <input name="linux" type="number" placeholder="Linux" value="{$this->game?->getLinux()}">
                </label>
                <label>
                    <input name="windows" type="number" placeholder="Windows" value="{$this->game?->getWindows()}">
                </label>
                <label>
                    <input name="year" type="number" placeholder="Année" value="{$this->game?->getReleaseYear()}">
                </label>
            </div>
            <button type="submit" class="update-button" style="background-color: #007bff; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                Enregistrer
            </button>
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
            throw new ParameterException(("Le nom ne correspond à aucun jeu"));
        }

        if(empty($_POST['desc'])) {
            throw new ParameterException(("La description ne correspond à aucun jeu"));
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