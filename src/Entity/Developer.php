<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Developer
{
    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Developer
    {
        $sql = MyPdo::getInstance()->prepare("SELECT * FROM developer WHERE id = :id");

        $sql->execute(["id" => $id]);

        $res = $sql->fetchObject(Developer::class);

        if (!$res) {
            throw new EntityNotFoundException("Developer with Id $id not found");
        }

        return $res;
    }

    public static function findAll(): array
    {
        $sql = MyPdo::getInstance()->prepare(<<<SQL
            SELECT *
            FROM developer
        SQL);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_CLASS, Developer::class);
    }

}
