<?php
declare(strict_types=1);

namespace App\Application\Actions\Hexagon;

use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;

class AddHexagonAction extends HexagonAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->getFormData();
        $hexagon = $body['hexagon'];

        if (empty($hexagon)) {
            throw new HttpBadRequestException($this->request);
        }

        $status = $this->hexagonRepository->addHexagon($hexagon);
        $this->logger->info("Added a hexagon");

        return $this->respondWithData($status);
    }
}
