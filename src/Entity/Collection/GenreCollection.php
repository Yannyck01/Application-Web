<?php

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Genre;
use Database\MyPdo;
use PDO;

class GenreCollection
{
    public static function findAll(): array
    {
        $sql=MyPdo::getInstance()->prepare(<<<SQL
SELECT *
FROM genre
ORDER BY id
SQL
);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_CLASS,Genre::class);

    }

}