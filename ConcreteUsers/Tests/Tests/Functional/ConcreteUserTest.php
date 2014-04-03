<?php
namespace ConcreteUsers\Tests\Tests\Functional;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;

final class ConcreteUserTest extends \PHPUnit_Framework_TestCase {
    
    private $dependencyInjectionFunctionTestHelper;
    private $jsonFilePathElement;
    private $entityJsonFilePathElement;
    private $uuidJsonFilePathElement;
    private $stringJsonFilePathElement;
    private $stringSetJsonFilePathElement;
    private $dateTimeFilePathElement;
    private $booleanFilePathElement;
    private $uuidElement;
    private $usernameElement;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $uuidObjectsData;
    private $stringObjectsData;
    private $dateTimeObjectsData;
    private $booleanObjectsData;
    public function setUp() {
        
        $this->dependencyInjectionFunctionTestHelper = new ConcreteDependencyInjectionFunctionalTestHelper(__DIR__.'/../../../../vendor');
        
        $this->jsonFilePathElement = realpath(__DIR__.'/../../../../dependencyinjection.json');
        $this->entityJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteentities/dependencyinjection.json');
        $this->uuidJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteuuids/dependencyinjection.json');
        $this->stringJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestrings/dependencyinjection.json');
        $this->stringSetJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestringsets/dependencyinjection.json');
        $this->dateTimeFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretedatetimes/dependencyinjection.json');
        $this->booleanFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebooleans/dependencyinjection.json');
        
        $this->uuidElement = 'ca3497a0-b00b-11e3-a5e2-0800200c9a66';
        $this->usernameElement = 'rogercyr';
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        
        $this->uuidObjectsData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->uuidJsonFilePathElement);
        $this->stringObjectsData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->stringJsonFilePathElement);
        $this->dateTimeObjectsData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->dateTimeFilePathElement);
        $this->booleanObjectsData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->booleanFilePathElement);
    }
    
    public function tearDown() {
        
    }
    
    
    private function buildUser() {
        
        $objectsData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->jsonFilePathElement);
        
        $uuid = $this->uuidObjectsData['adapter']->convertElementToUuid($this->uuidElement);
        $username = $this->stringObjectsData['adapter']->convertElementToPrimitive($this->usernameElement);
        $createdOn = $this->dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($this->createdOnTimestampElement);
        $lastUpdatedOn = $this->dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($this->lastUpdatedOnTimestampElement);
        
        return $objectsData['builderfactory']->create()
                                                ->create()
                                                ->withUuid($uuid)
                                                ->withUsername($username)
                                                ->createdOn($createdOn)
                                                ->lastUpdatedOn($lastUpdatedOn)
                                                ->now();
        
    }
    
    public function testConvertPermission_toHashMap_toPermission_Success() {
        
        $entitiesObjectData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->entityJsonFilePathElement);
        
        //convert the object into hashmap:
        $user = $this->buildUser();
        $hashMap = $entitiesObjectData['adapter']->convertEntityToHashMap($user);
        $this->assertTrue($hashMap instanceof \HashMaps\Domain\HashMaps\HashMap);
        
        //convert hashmap back to a User object:
        $convertedUser = $entitiesObjectData['adapter']->convertHashMapToEntity($hashMap);
        $this->assertEquals($user, $convertedUser);
        
    }
    
}