<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Game
{
    private int $id;
    private string $name;
    protected int $releaseYear;
    private string $shortDescription;
    protected int $price;
    protected int $windows;
    protected int $linux;
    protected int $mac;
    protected ?int $metacritic;
    protected ?int $developerId;
    protected int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getWindows(): int
    {
        return $this->windows;
    }

    public function setWindows(int $windows): void
    {
        $this->windows = $windows;
    }

    public function getLinux(): int
    {
        return $this->linux;
    }

    public function setLinux(int $linux): void
    {
        $this->linux = $linux;
    }

    public function getMac(): int
    {
        return $this->mac;
    }

    public function setMac(int $mac): void
    {
        $this->mac = $mac;
    }

    public function getMetacritic(): ?int
    {
        return $this->metacritic;
    }

    public function setMetacritic(?int $metacritic): void
    {
        $this->metacritic = $metacritic;
    }

    public function getDeveloperId(): int
    {
        return $this->developerId;
    }

    public function setDeveloperId(int $developerId): void
    {
        $this->developerId = $developerId;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
    }

    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /***
     * @param int $genreId
     * @return Game[]
     */
    public static function findByGenreId(int $genreId): array
    {
        $request = MyPdo::getInstance()->prepare(<<< SQL
            SELECT *
            FROM game g 
            JOIN game_genre gg ON g.id=gg.gameId
            WHERE genreId = :id
            SQL
        );
        $request->execute([":id" => $genreId]);
        $res=$request->fetchAll(PDO::FETCH_CLASS,Game::class);
        return $res;
    }

}