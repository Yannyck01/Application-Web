<?php
declare(strict_types=1);


use Entity\Game;

class GameForm {
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



    public function getHtmlForm(string $action) {
        return <<<HTML
        <form name="gameForm"  action="$action" method="POST">
            <div class="container">
                <h1>Création d'un nouveau jeu</h1>
                <label>
                    <input name="game__name" type="text" placeholder="Game Name" value="name">
                </label>
                <label>
                    <input name="id" type="hidden" placeholder="ID" value="{$this->game?->getId()}">
                </label>
                <label>
                    <input name="desc" type="text" placeholder="Description" value="desc">
                </label>
                <label>
                    <input name="price__euro" type="number" placeholder="price in euro" value="price">
                </label>
                <label>
                    <input name="grade__100" type="number" placeholder="Grade out of 100" value="grade">
                </label>
            </div>
        </form>

    HTML;

    }

    public function setFromQueryQString() {
        $name = $_POST['game__name'];
        $id = $_POST['id'];
        $description = $_POST['desc'];
        $price = $_POST['price__euro'];
        $grade = $_POST['grade__100'];
        $this->game = new Game();

    }

}