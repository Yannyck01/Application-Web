<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Form\GameForm;
use Entity\Game;
use Exception\ParameterException;
use Html\WebPage;


try {
    if(!isset($_GET['gameId'])) {
        $game = null;
    } else {
        if (!is_numeric($_GET['gameId'])) {
            throw new ParameterException("Le type de l'id est incorrect, veuillez saisir un entier");
        }
        $id = (int) $_GET['gameId'];
        $game = Game::findById($id);

}
   $gameForm = new GameForm($game);
   $form = $gameForm->getHtmlForm("game-save.php");
   $formHtml=new WebPage("Création d'un nouveau jeu");
   $formHtml->appendCssUrl("../css/style.css");
   $formHtml->appendContent($form);
   echo $formHtml->toHTML();

} catch (ParameterException) {
    http_response_code(400);
    echo "L'un des champs nécessaire à la création du jeu n'est pas renseigné";
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}

