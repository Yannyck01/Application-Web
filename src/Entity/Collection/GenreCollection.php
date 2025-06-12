<?php

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Exception\EntityNotFoundException;
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
ORDER BY description
SQL
);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_CLASS,Genre::class);

    }

    public static function findByGameId(int $gameId): array
    {
        $sql=MyPdo::getInstance()->prepare(<<<SQL
SELECT *
FROM genre g
JOIN game_genre gg ON (g.id=gg.genreId)
WHERE gameId = :id
ORDER BY g.description
SQL);
        $sql->execute(["id"=>$gameId]);

        $res=$sql->fetchAll(PDO::FETCH_CLASS, Genre::class);

        return $res;
    }

}