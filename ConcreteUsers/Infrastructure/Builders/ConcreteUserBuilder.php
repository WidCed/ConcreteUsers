<?php
namespace ConcreteUsers\Infrastructure\Builders;
use ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder;
use Users\Domain\Users\Builders\UserBuilder;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter;
use Strings\Domain\Strings\String;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;
use Roles\Domain\Roles\Role;

final class ConcreteUserBuilder extends AbstractEntityBuilder implements UserBuilder {
    
    private $username;
    private $role;
    public function __construct(BooleanAdapter $booleanAdapter, ObjectLoaderAdapter $objectLoaderAdapter) {
        parent::__construct($booleanAdapter, $objectLoaderAdapter, 'ConcreteUsers\Infrastructure\Objects\ConcreteUser');
    }
    
    public function create() {
        $this->username = null;
        $this->role = null;
        return parent::create();
    }
    
    public function withUsername(String $username) {
        $this->username = $username;
        return $this;
    }
    
    public function withRole(Role $role) {
        $this->role = $role;
        return $this;
    }
    
    protected function getParamsData() {
        
        $lastUpdatedOn = null;
        if (!empty($this->lastUpdatedOn)) {
            $lastUpdatedOn = $this->lastUpdatedOn;
        }
        
        $role = null;
        if (!empty($this->role)) {
            $role = $this->role;
        }
        
        return array($this->uuid, $this->username, $this->createdOn, $this->booleanAdapter, $lastUpdatedOn, $role);
        
    }
    
    public function now() {
        
        if (empty($this->username)) {
            throw new CannotBuildEntityException('The username is mandatory in order to build a User object.');
        }
        
        return parent::now();
        
    }
}