<?php

declare(strict_types=1);

use Html\WebPage;

$pageTest = new WebPage("Test of the WebPage class");

$pageTest->appendContent("<h1>Test of the Webpage class</h1>");

echo $pageTest->toHTML();
