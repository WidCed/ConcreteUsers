<?php
namespace ConcreteUsers\Tests\Tests\Functional;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteUsers\Tests\Helpers\StaticUserHelper;

final class ConcreteUserTest extends \PHPUnit_Framework_TestCase {
    
    private $objectsData;
    public function setUp() {
        $dependencyInjectionFunctionTestHelper = new ConcreteDependencyInjectionFunctionalTestHelper(__DIR__.'/../../../../vendor');
        $jsonFilePathElement = realpath(__DIR__.'/../../../../dependencyinjection.json');
        $roleJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteroles/dependencyinjection.json');
        $permissionJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretepermissions/dependencyinjection.json');
        $entitySetJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteentitysets/dependencyinjection.json');
        $uuidJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteuuids/dependencyinjection.json');
        $stringJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestrings/dependencyinjection.json');
        $dateTimeFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretedatetimes/dependencyinjection.json');
        $booleanFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebooleans/dependencyinjection.json');
        
        StaticUserHelper::setUp(
            $dependencyInjectionFunctionTestHelper,
            $jsonFilePathElement, 
            $roleJsonFilePathElement, 
            $permissionJsonFilePathElement, 
            $entitySetJsonFilePathElement, 
            $uuidJsonFilePathElement, 
            $stringJsonFilePathElement, 
            $dateTimeFilePathElement, 
            $booleanFilePathElement
        );
        
        $this->objectsData = $dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        $this->objectsData['irestful.concreteobjectmetadatacompilerapplications.application']->compile();
    }
    
    public function tearDown() {
        
    }
    
    public function testConvertPermission_toHashMap_toPermission_Success() {
        
        $user = StaticUserHelper::getObject();
        
        //convert the object into hashmap:
        $hashMap = $this->objectsData['irestful.concreteentities.adapter']->convertEntityToHashMap($user);
        $this->assertTrue($hashMap instanceof \HashMaps\Domain\HashMaps\HashMap);
        
        //convert hashmap back to a User object:
        $convertedUser = $this->objectsData['irestful.concreteentities.adapter']->convertHashMapToEntity($hashMap);
        $this->assertEquals($user, $convertedUser);
        
    }
    
}