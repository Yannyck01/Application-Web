<?php
declare(strict_types=1);

namespace html;

class AppWebPage extends WebPage{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
    }
    public function toHTML(): string
    {

        $HTML = <<<HTML

        <!DOCTYPE html>
        <html lang="fr">
        <head>
        <meta charset="UTF-8" name="viewport">
                <title>{$this->getTitle()}</title>
        
        </head>
        <body>
            <header class="header">
                <h1>{$this->getTitle()}</h1>
            </header>
            <br>
         <div class="content">

            {$this->getBody()}

        </div>

         

          <footer class="footer">
          {$this->getLastModification()}
          </footer>
         </body>
        </html>


        HTML;
        return $HTML;

    }
}