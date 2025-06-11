<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    private string $head = "";
    private string $title = "";
    private string $body = "";

    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    public function getHead(): string
    {
        return $this->head;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    public function appendCss(string $css): void
    {
        $this->head = "$this->head\n<style>$css</style>";
    }

    public function appendCssUrl(string $url): void
    {
        $this->appendToHead("<link rel=\"stylesheet\" href=\"$url\"/>");

    }

    public function appendJs(string $js): void
    {
        $this->head .= "<script>$js</script>";

    }

    public function appendJsUrl(string $jsUrl): void
    {
        $this->head = "$this->head<script src='$jsUrl'></script>";

    }

    public function appendContent(string $content): void
    {
        $this->body .= $content;

    }

    public function toHTML(): string
    {
        $HTML = <<<HTML
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" name="viewport">
        <title>{$this->escapeString($this->title)}</title>
        {$this->head}
    </head>
    <body>
        {$this->body}
        <div class="footer">
            <i>Dernière modification de cette page le {$this->getLastModification()}</i>
        </div>
    </body>
</html>
HTML;
        return $HTML;
    }

    public function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES |  ENT_HTML5);
    }

    public function getLastModification(): string
    {
        return date("j/m/Y \à H:i:s", getlastmod());
    }
}
