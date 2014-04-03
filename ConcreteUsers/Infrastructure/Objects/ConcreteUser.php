<?php
namespace ConcreteUsers\Infrastructure\Objects;
use ConcreteEntities\Infrastructure\Objects\AbstractEntity;
use Users\Domain\Users\User;
use Uuids\Domain\Uuids\Uuid;
use DateTimes\Domain\DateTimes\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use Strings\Domain\Strings\String;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;
use ConcreteClassAnnotationObjects\Infrastructure\Objects\ConcreteContainer;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteKeyname;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteTransform;

/**
 * @ConcreteContainer("user") 
 */
final class ConcreteUser extends AbstractEntity implements User {
    
    private $username;
    public function __construct(Uuid $uuid, String $username, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null) {
        
        if ($username->get() == '') {
            throw new CannotCreateEntityException('The username must be a non-empty String object.');
        }
        
        parent::__construct($uuid, $createdOn, $booleanAdapter, $lastUpdatedOn);
        $this->username = $username;
        
    }
    
    /**
     * @ConcreteKeyname(name="username", argument="username")
     * @ConcreteTransform(reference="irestful.concretestrings.adapter", method="convertElementToPrimitive")
     **/
    public function getUsername() {
        return $this->username;
    }
}