<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;

class Category
{
    private int $id;
    private string $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public static function findById(int $id): Category
    {
        $sql=MyPdo::getInstance()->prepare("SELECT * FROM category WHERE id = :id");

        $sql->execute(["id" => $id]);

        $res=$sql->fetchObject(Category::class);

        return $res;
    }




}