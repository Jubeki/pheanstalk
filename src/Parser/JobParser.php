<?php
declare(strict_types=1);

namespace Pheanstalk\Parser;

use Pheanstalk\Contract\CommandInterface;
use Pheanstalk\Contract\ResponseInterface;
use Pheanstalk\Contract\ResponseParserInterface;
use Pheanstalk\JobId;
use Pheanstalk\Response\JobIdResponse;
use Pheanstalk\Response\JobResponse;
use Pheanstalk\ResponseType;

class JobParser implements ResponseParserInterface
{
    public function __construct(private readonly ResponseType $type) {}

    public function parseResponse(
        CommandInterface $command,
        ResponseType $type,
        array $arguments = [],
        ?string $data = null
    ): null|ResponseInterface {
        if ($type !== $this->type) {
            return null;

        }
        if (isset($data)) {
            return new JobResponse($type, new JobId($arguments[0]), $data);
        } else {
            return new JobIdResponse($type, new JobId($arguments[0]));
        }

    }
}