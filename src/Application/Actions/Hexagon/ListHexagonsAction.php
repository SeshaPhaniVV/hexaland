<?php
declare(strict_types=1);

namespace App\Application\Actions\Hexagon;

use Slim\Psr7\Response;

class ListHexagonsAction extends HexagonAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hexagons = $this->hexagonRepository->findAll();

        $this->logger->info("Hexagons list was viewed.");

        return $this->respondWithData($hexagons);
    }
}
