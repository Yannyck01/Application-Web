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
ORDER BY description
SQL
        );
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_CLASS,Category::class);

    }

    public static function findByGameId(int $gameId): array
    {
        $sql=MyPdo::getInstance()->prepare(<<<SQL
SELECT *
FROM category c
JOIN game_category gc ON (c.id=gc.categoryId)
WHERE gameId = :id
ORDER BY c.description
SQL);
        $sql->execute(["id"=>$gameId]);

        $res=$sql->fetchAll(PDO::FETCH_CLASS, Category::class);

        return $res;
    }
}