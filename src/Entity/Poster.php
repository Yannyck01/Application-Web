<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;

class Poster
{
    private int $id;
    private string $jpeg;

    public function getId(): int
    {
        return $this->id;
    }

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    public static function findById(int $id): Poster
    {
        $sql = MyPDO::getInstance()->prepare("SELECT * FROM poster WHERE id = :id");

        $sql->execute([':id' => $id]);

        $result = $sql->fetchObject(Poster::class);

        if (!$result) {
            throw new EntityNotFoundException("ID $id not found.");
        }

        return $result;
    }
}