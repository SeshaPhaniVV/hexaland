<?php
declare(strict_types=1);

namespace App\Domain\Hexagon;

interface HexagonRepository
{
    /**
     * @return Hexagon[]
     */
    public function findAll(): array;

    /**
     * @param string $name
     *
     * @throws HexagonNotFoundException
     */
    public function findHexagonOfName(string $name);

    /**
     * @param array $hexagon
     *
     * @return Hexagon
     */
    public function addHexagon(array $hexagon): Hexagon;

    /**
     * @param Hexagon $hexagon
     *
     * @return array
     */
    public function getNeighborsOfHexagon(Hexagon $hexagon): array;

    /**
     * @param string $name
     *
     * @return bool
     *
     * @throws \App\Domain\Hexagon\HexagonNotFoundException
     */
    public function deleteHexagonOfName(string $name): bool;
}
