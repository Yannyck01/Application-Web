<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public static function findById(int $id): Genre
    {
        $sql = MyPdo::getInstance()->prepare("SELECT * FROM genre WHERE id = :id");

        $sql->execute(["id" => $id]);

        $res = $sql->fetchObject(Genre::class);

        if (!$res) {
            throw new EntityNotFoundException("Genre with ID $id not found");
        }

        return $res;
    }


}
