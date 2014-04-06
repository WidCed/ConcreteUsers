<?php
namespace ConcreteUsers\Tests\Tests\Functional;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteUsers\Tests\Helpers\ConcreteUserHelper;

final class ConcreteUserTest extends \PHPUnit_Framework_TestCase {
    
    private $dependencyInjectionFunctionTestHelper;
    private $userHelper;
    public function setUp() {
        
        $this->dependencyInjectionFunctionTestHelper = new ConcreteDependencyInjectionFunctionalTestHelper(__DIR__.'/../../../../vendor');
        $this->entityJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteentities/dependencyinjection.json');
        
        $jsonFilePathElement = realpath(__DIR__.'/../../../../dependencyinjection.json');
        $roleJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteroles/dependencyinjection.json');
        $permissionJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretepermissions/dependencyinjection.json');
        $entitySetJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteentitysets/dependencyinjection.json');
        $uuidJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteuuids/dependencyinjection.json');
        $stringJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestrings/dependencyinjection.json');
        $dateTimeFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretedatetimes/dependencyinjection.json');
        $booleanFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebooleans/dependencyinjection.json');
        
        $this->userHelper = new ConcreteUserHelper(
            $this->dependencyInjectionFunctionTestHelper, 
            $jsonFilePathElement, 
            $roleJsonFilePathElement, 
            $permissionJsonFilePathElement, 
            $entitySetJsonFilePathElement, 
            $uuidJsonFilePathElement, 
            $stringJsonFilePathElement, 
            $dateTimeFilePathElement, 
            $booleanFilePathElement
        );
    }
    
    public function tearDown() {
        
    }
    
    public function testConvertPermission_toHashMap_toPermission_Success() {
        
        $entitiesObjectData = $this->dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($this->entityJsonFilePathElement);
        
        //convert the object into hashmap:
        $user = $this->userHelper->build();
        $hashMap = $entitiesObjectData['adapter']->convertEntityToHashMap($user);
        $this->assertTrue($hashMap instanceof \HashMaps\Domain\HashMaps\HashMap);
        
        //convert hashmap back to a User object:
        $convertedUser = $entitiesObjectData['adapter']->convertHashMapToEntity($hashMap);
        $this->assertEquals($user, $convertedUser);
        
    }
    
}