<?php
namespace ConcreteUsers\Tests\Helpers;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteRoles\Tests\Helpers\StaticRoleHelper;

final class StaticUserHelper {
    private static $roleHelper;
    private static $objectsData;
    private static $uuidObjectsData;
    private static $stringObjectsData;
    private static $dateTimeObjectsData;
    private static $object;
    
    public static function isSetUp() {
        return !empty(self::$object);
    }
    
    public static function setUp (
        ConcreteDependencyInjectionFunctionalTestHelper $depdendencyInjectionFunctionalTestHelper,
        $jsonFilePathElement,
        $roleJsonFilePathElement,
        $permissionJsonFilePathElement,
        $entitySetJsonFilePathElement,
        $uuidJsonFilePathElement,
        $stringJsonFilePathElement,
        $dateTimeFilePathElement,
        $booleanFilePathElement
    ) {
        
        if (self::isSetUp()) {
            return;
        }
        
        StaticRoleHelper::setUp(
            $depdendencyInjectionFunctionalTestHelper, 
            $roleJsonFilePathElement,
            $permissionJsonFilePathElement, 
            $entitySetJsonFilePathElement,
            $uuidJsonFilePathElement, 
            $stringJsonFilePathElement, 
            $dateTimeFilePathElement, 
            $booleanFilePathElement
        );
        
        self::$objectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        self::$uuidObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($uuidJsonFilePathElement);
        self::$stringObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($stringJsonFilePathElement);
        self::$dateTimeObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($dateTimeFilePathElement);
        
        self::$object = self::build();
    }
    
    public static function getObject() {
        return self::$object;
    }
    
    public static function getObjectWithSubObjects() {
        $objectsData = StaticRoleHelper::getObjectWithSubObjects();
        return array_merge(array(self::$object), $objectsData);
    }
    
    public static function build() {
        
        $uuidElement = 'ca3497a0-b00b-11e3-a5e2-0800200c9a66';
        $usernameElement = 'rogercyr';
        $createdOnTimestampElement = time() - (24 * 60 * 60);
        $lastUpdatedOnTimestampElement = time();
        
        $role = StaticRoleHelper::getObject();
        
        $uuid = self::$uuidObjectsData['adapter']->convertElementToUuid($uuidElement);
        $username = self::$stringObjectsData['adapter']->convertElementToPrimitive($usernameElement);
        $createdOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($createdOnTimestampElement);
        $lastUpdatedOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($lastUpdatedOnTimestampElement);
        
        return self::$objectsData['builderfactory']->create()
                                                    ->create()
                                                    ->withUuid($uuid)
                                                    ->withUsername($username)
                                                    ->withRole($role)
                                                    ->createdOn($createdOn)
                                                    ->lastUpdatedOn($lastUpdatedOn)
                                                    ->now();
    }
}