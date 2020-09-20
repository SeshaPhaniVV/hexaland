<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Hexagon;

use App\Domain\Hexagon\CriticalHexagonDeleteException;
use App\Domain\Hexagon\Hexagon;
use App\Domain\Hexagon\HexagonAlreadyExistsException;
use App\Domain\Hexagon\HexagonNotFoundException;
use App\Domain\Hexagon\HexagonRepository;
use Exception;

class HexagonService implements HexagonRepository
{
    /**
     * @var Hexagon[]
     */
    private $hexagons;

    /**
     * InMemoryUserRepository constructor.
     *
     */
    public function __construct()
    {
        $this->hexagons = Hexagon::query()->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->hexagons->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function findHexagonOfId(int $id, bool $includeNeighbors = false): Hexagon
    {
        $hexagon = $this->hexagons->where('id', $id)->first();

        if (is_null($hexagon)) {
            throw new HexagonNotFoundException();
        }

        return $hexagon;
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws HexagonNotFoundException
     */
    public function getNeighborsOfHexagon(int $id): array
    {
        $coords = $this->getCoords($id);
        $neighborCoords = $this->getNeighborCoords($coords);

        return Hexagon::query()->whereIn('coords', $neighborCoords)->get()->toArray();
    }

    /**
     * @param array $hexagon
     *
     * @return Hexagon
     *
     * @throws HexagonAlreadyExistsException|HexagonNotFoundException
     */
    public function addHexagon(array $hexagon): Hexagon
    {
        $hexRecord = Hexagon::findByName($hexagon['neighbor']);

        if (is_null($hexRecord)) {
            throw new HexagonNotFoundException();
        }

        $coords = $this->getCoords($hexRecord['id']);
        $new_coords = $this->getNewCoords($hexagon['position'], $coords);
        $name = $hexagon['name'];

        $newHexByCoords = Hexagon::findByCoords($new_coords);

        if (!empty($newHexByCoords)) {
            throw new HexagonAlreadyExistsException();
        }

        $newHexByName = Hexagon::findByName($name);

        if (!empty($newHexByName)) {
            throw new HexagonAlreadyExistsException();
        }

        $newHexagon = new Hexagon([
            'coords' => $new_coords,
            'name' => $name
        ]);

        $newHexagon->save();
        return $newHexagon;
    }

    /**
     * @param string $name
     * @return bool
     *
     * @throws CriticalHexagonDeleteException
     * @throws HexagonNotFoundException
     * @throws Exception
     */
    public function deleteHexagonOfName(string $name): bool
    {
        $hexagon = Hexagon::findByName($name);

        if (is_null($hexagon)) {
            throw new HexagonNotFoundException();
        }

        $isValid = $this->validateDeletion($name);

        if (!$isValid) {
            throw new CriticalHexagonDeleteException();
        }
        $hexagon = Hexagon::findByName($name);
        return $hexagon->delete();
    }

    /**
     * @param string $coords
     *
     * @return mixed
     */
    private function getNeighborCoords(string $coords): array
    {
        $coords = explode(",", $coords);
        $neighbors = [[1, 0], [0, 1], [1, -1], [0, -1], [-1, 0], [-1, 1]];

        return array_map(function ($neighbor) use ($coords) {
            $x = $coords[0] + $neighbor[0];
            $y = $coords[1] + $neighbor[1];
            return "$x,$y";
        }, $neighbors);
    }

    /**
     * @param string $name
     * @return bool
     *
     * @throws HexagonNotFoundException
     */
    private function validateDeletion(string $name): bool
    {
        $hexagons = Hexagon::query()->whereNotIn('name', [$name]);
        $hexagon = Hexagon::findByName($name);
        $queue = $this->getNeighborsOfHexagon($hexagon['id']);
        if (empty($queue)) {
            return false;
        }
        $queue = [$queue[0]['coords']];
        $visited = [];
        $total = $hexagons->count();

        // We should atleast have one record in db.
        if ($total === 0) {
            return false;
        }

        while(sizeof($queue) > 0) {
            $len = sizeof($queue);
            for ($i = 0; $i < $len; $i++) {
                $tempHex = clone $hexagons;
                $hex = array_pop($queue);
                array_push($visited, $hex);
                $neighborCoords = $this->getNeighborCoords($hex);
                $neighbors = $tempHex->whereIn('coords', $neighborCoords)->get();
                $neighbors = $neighbors->whereNotIn('coords', $visited)->pluck('coords')->toArray();
                $queue = array_values(array_unique(array_merge($neighbors, $queue)));
            }
        }

        return sizeof($visited) === $total;
    }

    /**
     * @param $id
     *
     * @return string
     *
     * @throws HexagonNotFoundException
     */
    private function getCoords($id): string
    {
        $hexagon = $this->findHexagonOfId($id);
        return $hexagon['coords'];
    }

    /**
     * @param int $position
     * @param string $coords
     *
     * @return string
     */
    private function getNewCoords(int $position, string $coords): string
    {
       $positionMap = [
           0 => [0, -1], 1 => [1, -1], 2 => [1, 0], 3 => [0, 1], 4 => [-1, 1], 5 => [-1, 0],
       ];

       $pos = $positionMap[$position];

        $coords = explode(",", $coords);
        $newCoords[0] = $coords[0] + $pos[0];
        $newCoords[1] = $coords[1] + $pos[1];

        return "$newCoords[0],$newCoords[1]";
    }
}
