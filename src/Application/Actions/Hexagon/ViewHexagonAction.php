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
        $hexagonName = $this->resolveArg('name');
        $response['hexagon'] = $this->hexagonRepository->findHexagonOfName($hexagonName);

        $include_neighbors = (bool) $this->getQueryParam('include_neighbors');

        if ($include_neighbors) {
            $nei = $this->hexagonRepository->getNeighborsOfHexagon($response['hexagon']);
            $response['neighbors'] = $nei;
        }

        return $this->respondWithData($response);
    }
}
