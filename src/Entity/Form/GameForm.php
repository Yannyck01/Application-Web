<?php
declare(strict_types=1);


namespace Entity\Form;

use Entity\Game;

class GameForm
{
    private ?Game $game;

    /**
     * @param Game|null $game
     */
    public function __construct(?Game $game = null)
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
        $mac = $this->game?->getMac() ? 'checked' : '';
        $linux = $this->game?->getLinux() ? 'checked' : '';
        $windows = $this->game?->getWindows() ? 'checked' : '';

        return <<<HTML
    <div class="header">
        <h1>Création d'un nouveau jeu</h1>
    </div>
    <style>
        .container {
            display: flex;
            width: 99%;
            flex-direction: column;
            gap: 20px;
        }
        .container label {
            display: flex;
            flex-direction: column;
            font-weight: bold;
            gap: 5px;
        }
        .container input[type="text"],
        .container input[type="number"],
        .container textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .checkbox-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .checkbox-group label {
            flex-direction: row;
            align-items: center;
            gap: 5px;
            font-weight: normal;
        }
        .update-button {
            padding-top: 2rem;
        }
    </style>
    <form name="gameForm" action="$action" method="POST" class="game__form">
        <div class="container">
            <label>
                Nom :
                <input name="name" type="text" placeholder="Nom" value="{$this->game?->getName()}">
            </label>
            <input name="id" type="hidden" value="{$this->game?->getId()}">
            <label>
                Description :
                <textarea name="desc" placeholder="Description">{$this->game?->getShortDescription()}</textarea>
            </label>
            <label>
                Prix :
                <input name="price" type="number" placeholder="Prix" value="{$this->game?->getPrice()}">
            </label>
            <label>
                Note sur 100 :
                <input name="grade" type="number" placeholder="Note sur 100" value="{$this->game?->getMetacritic()}">
            </label>
            <label>
                Id Poster :
                <input name="posterId" type="number" placeholder="Id Poster" value="{$this->game?->getPosterId()}">
            </label>
            <label>
                Id Développeur :
                <input name="devId" type="number" placeholder="Id Développeur" value="{$this->game?->getDeveloperId()}">
            </label>

            <div class="checkbox-group">
                <label>Disponible sur :</label> 
                <label><input type="checkbox" name="mac" value="1" {$mac}> Mac</label>
                <label><input type="checkbox" name="linux" value="1" {$linux}> Linux</label>
                <label><input type="checkbox" name="windows" value="1" {$windows}> Windows</label>
            </div>

            <label>
                Année :
                <input name="year" type="number" placeholder="Année" value="{$this->game?->getReleaseYear()}">
            </label>

            <button type="submit" class="update-button" style="background-color: #007bff; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                Enregistrer
            </button>
        </form>

    HTML;
    }

    public function setEntityFromQueryString(): void
    {
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = (int)$_POST['id'];
        } else {
            $id = null;
        }

        $name = $_POST['name'];
        $grade=(int)$_POST['grade'];
        $price=(int)$_POST['price'];
        $desc=$_POST['desc'];
        $posterId =(int)$_POST['posterId'];
        $devId=(int)$_POST['devId'];
        $mac=(int)$_POST['mac'];
        $linux=(int)$_POST['linux'];
        $windows=(int)$_POST['windows'];
        $year=(int)$_POST['year'];

        $this->game = Game::create($id,$name,$year,$desc,$price,$windows,$linux,$mac,$grade,$devId,$posterId);
    }
}