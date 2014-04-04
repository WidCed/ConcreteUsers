<?php
namespace ConcreteUsers\Infrastructure\Proxies;
use Entities\Domain\Exceptions\EntityException;

final class PrimitiveProxyException extends EntityException {
    const CODE = 1;
    public function __construct($message, EntityException $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}