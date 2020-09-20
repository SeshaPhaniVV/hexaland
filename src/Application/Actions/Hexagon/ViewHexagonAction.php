<?php
declare(strict_types=1);

namespace App\Application\Actions\Hexagon;

use Slim\Psr7\Response;

class ViewHexagonAction extends HexagonAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hexagonId = (int) $this->resolveArg('id');
        $response['hexagon'] = $this->hexagonRepository->findHexagonOfId($hexagonId);

        $include_neighbors = (bool) $this->getQueryParam('include_neighbors');

        if ($include_neighbors) {
            $nei = $this->hexagonRepository->getNeighborsOfHexagon($hexagonId);
            $response['neighbors'] = $nei;
        }

        return $this->respondWithData($response);
    }
}
