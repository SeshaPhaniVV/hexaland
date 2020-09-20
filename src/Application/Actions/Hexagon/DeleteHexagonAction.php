<?php
declare(strict_types=1);

namespace App\Application\Actions\Hexagon;

use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;

class DeleteHexagonAction extends HexagonAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hexagonName = $this->resolveArg('name');

        if (empty($hexagonName)) {
            throw new HttpBadRequestException($this->request);
        }

        $status = $this->hexagonRepository->deleteHexagonOfName($hexagonName);

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($status);
    }
}
