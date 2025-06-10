<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Category;
use PDO;

class CategoryCollection
{
    public static function findAll(): array
    {
        $sql=MyPdo::getInstance()->prepare(<<<SQL
SELECT *
FROM category
ORDER BY id
SQL
        );
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_CLASS,Category::class);

    }
}