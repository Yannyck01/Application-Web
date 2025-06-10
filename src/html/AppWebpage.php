<?php
declare(strict_types=1);

namespace html;

class AppWebPage extends WebPage{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
    }
}