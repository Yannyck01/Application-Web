<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Game
{
    private ?int $id;
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

    /**
     * @param int $posterId
     * @param int|null $developerId
     * @param int|null $metacritic
     * @param int $mac
     * @param int $linux
     * @param int $windows
     * @param int $price
     * @param string $shortDescription
     * @param int $releaseYear
     * @param string $name
     * @param int|null $id
     */



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Game
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Game
    {
        $this->name = $name;
        return $this;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): Game
    {
        $this->releaseYear = $releaseYear;
        return $this;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): Game
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Game
    {
        $this->price = $price;
        return $this;
    }

    public function getWindows(): int
    {
        return $this->windows;
    }

    public function setWindows(int $windows): Game
    {
        $this->windows = $windows;
        return $this;
    }

    public function getLinux(): int
    {
        return $this->linux;
    }

    public function setLinux(int $linux): Game
    {
        $this->linux = $linux;
        return $this;
    }

    public function getMac(): int
    {
        return $this->mac;
    }

    public function setMac(int $mac): Game
    {
        $this->mac = $mac;
        return $this;
    }

    public function getMetacritic(): ?int
    {
        return $this->metacritic;
    }

    public function setMetacritic(?int $metacritic): Game
    {
        $this->metacritic = $metacritic;
        return $this;
    }

    public function getDeveloperId(): int
    {
        return $this->developerId;
    }

    public function setDeveloperId(int $developerId): Game
    {
        $this->developerId = $developerId;
        return $this;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
    }

    public function setPosterId(int $posterId): Game
    {
        $this->posterId = $posterId;
        return $this;
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

    public static function findByCategoryId(int $categoryId): array
    {
        $requestCtg = MyPdo::getInstance()->prepare(<<< SQL
        SELECT *
        FROM game g
        JOIN game_category ctg ON g.id=ctg.gameId
        WHERE categoryId = :idCtg

SQL);
        $requestCtg->execute([":idCtg"=> $categoryId]);
        $res = $requestCtg->fetchAll(PDO::FETCH_CLASS,Game::class);

        return $res;

    }

    public static function findById(int $id): Game
    {
        $requestId = MyPdo::getInstance()->prepare( <<< 'SQL'
            SELECT id, name, releaseYear, shortDescription, price,
                   windows, linux, mac,metacritic, developerId, posterId
            FROM game
            WHERE id = :id
            
        SQL);
        $requestId->execute([":id"=> $id]);
        $res = $requestId->fetchObject(Game::class);

        if (!$res) {
            throw new EntityNotFoundException("The game id $id does not match any game");
        }
        return $res;
    }

    public function delete(): Game
    {
        $sql = MyPdo::getInstance()->prepare("DELETE FROM game WHERE id = :id");

        $sql->execute([":id"=>$this->id]);

        $this->setId(null);

        return $this;
    }

    public function update( ) : Game
    {
        $requestUpdt = MyPdo::getInstance()->prepare(<<<'SQL'
        UPDATE game SET name = :name, metacritic = :meta, developperId = :devId,
                        price = : price, shortDescription = :desc
        WHERE id = :id 
    SQL);
    $requestUpdt->execute(["name"=>$this->name,":meta"=>$this->metacritic,":price"=>$this->price,":desc"=>$this->shortDescription]);
    return $this;
    }

    public function create() : Game
    {
        $createRequest = MyPdo::getInstance()->prepare(<<< SQL
        INSERT INTO game ('name','shortDescription','price','developperId','metacritic')
        VALUES           ( :name, :shortDescription, :price, :developperId, :metacritic)

    SQL);
        $createRequest->execute(["name"=>$this->name,":meta"=>$this->metacritic,":price"=>$this->price,":desc"=>$this->shortDescription]);
        $this->setId((int)MyPdo::getInstance()->lastInsertId());

    }

    public function save(): Game
    {
        if($this->id == null){
            $this->insert();
        }
        else {
            $this->update();
        }
        return $this;
    }

    public static function create(?int $id = null, string $name, int $year, string $desc, int $price, int $windows, int $linux, int $mac, int $metacritic, int $devId, int $posterId)
    {
        return (new Game())->setId($id)->setName($name)->setReleaseYear($year)->setShortDescription($desc)->setPrice($price)->setWindows($windows)->setLinux($linux)->setMac($mac)->setMetacritic($metacritic)->setDeveloperId($devId)->setPosterId($posterId);
    }



}