<?php
namespace ConcreteUsers\Infrastructure\Builders;
use ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder;
use Users\Domain\Users\Builders\UserBuilder;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter;
use Strings\Domain\Strings\String;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteUserBuilder extends AbstractEntityBuilder implements UserBuilder {
    
    private $username;
    public function __construct(BooleanAdapter $booleanAdapter, ObjectLoaderAdapter $objectLoaderAdapter) {
        parent::__construct($booleanAdapter, $objectLoaderAdapter, 'ConcreteUsers\Infrastructure\Objects\ConcreteUser');
    }
    
    public function create() {
        $this->username = null;
        return parent::create();
    }
    
    public function withUsername(String $username) {
        $this->username = $username;
        return $this;
    }
    
    protected function getParamsData() {
        
        $paramsData = array($this->uuid, $this->username, $this->createdOn, $this->booleanAdapter);
        
        if (!empty($this->lastUpdatedOn)) {
            $paramsData[] = $this->lastUpdatedOn;
        }
        
        return $paramsData;
        
    }
    
    public function now() {
        
        if (empty($this->username)) {
            throw new CannotBuildEntityException('The username is mandatory in order to build a User object.');
        }
        
        return parent::now();
        
    }
}