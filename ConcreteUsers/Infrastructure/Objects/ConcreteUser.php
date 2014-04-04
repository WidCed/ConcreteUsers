<?php
namespace ConcreteUsers\Infrastructure\Objects;
use ConcreteEntities\Infrastructure\Objects\AbstractEntity;
use Users\Domain\Users\User;
use Uuids\Domain\Uuids\Uuid;
use DateTimes\Domain\DateTimes\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use Strings\Domain\Strings\String;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;
use Roles\Domain\Roles\Role;
use ConcreteClassAnnotationObjects\Infrastructure\Objects\ConcreteContainer;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteKeyname;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteTransform;
use Primitives\Domain\Primitives\Adapters\Exceptions\CannotConvertElementToPrimitiveException;
use ConcreteUsers\Infrastructure\Proxies\PrimitiveProxyException;
use Users\Domain\Users\Exceptions\CannotRequestHasRoleException;

/**
 * @ConcreteContainer("user") 
 */
final class ConcreteUser extends AbstractEntity implements User {
    
    private $username;
    private $role;
    public function __construct(Uuid $uuid, String $username, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null, Role $role = null) {
        
        if ($username->get() == '') {
            throw new CannotCreateEntityException('The username must be a non-empty String object.');
        }
        
        parent::__construct($uuid, $createdOn, $booleanAdapter, $lastUpdatedOn);
        $this->username = $username;
        $this->role = $role;
    }
    
    /**
     * @ConcreteKeyname(name="username", argument="username")
     * @ConcreteTransform(reference="irestful.concretestrings.adapter", method="convertElementToPrimitive")
     **/
    public function getUsername() {
        return $this->username;
    }
    
    public function hasRole() {
        
        try {
            
            $hasRole = !empty($this->role);
            return $this->booleanAdapter->convertElementToPrimitive($hasRole);
            
        } catch (CannotConvertElementToPrimitiveException $exception) {
            $proxy = new PrimitiveProxyException($exception);
            throw new CannotRequestHasRoleException('There was an exception while converting an element to a Boolean object.', $proxy);
        }

    }
    
    /**
     * @ConcreteKeyname(name="role", argument="role")
     **/
    public function getRole() {
        return $this->role;
    }
}