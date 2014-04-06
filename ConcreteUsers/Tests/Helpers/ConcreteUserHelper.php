<?php
namespace ConcreteUsers\Tests\Helpers;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteRoles\Tests\Helpers\ConcreteRoleHelper;

final class ConcreteUserHelper {
    private $roleHelper;
    private $objectsData;
    private $uuidObjectsData;
    private $stringObjectsData;
    private $dateTimeObjectsData;
    public function __construct(
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
        $this->roleHelper = new ConcreteRoleHelper(
            $depdendencyInjectionFunctionalTestHelper, 
            $roleJsonFilePathElement,
            $permissionJsonFilePathElement, 
            $entitySetJsonFilePathElement,
            $uuidJsonFilePathElement, 
            $stringJsonFilePathElement, 
            $dateTimeFilePathElement, 
            $booleanFilePathElement
        );
        
        $this->objectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        $this->uuidObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($uuidJsonFilePathElement);
        $this->stringObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($stringJsonFilePathElement);
        $this->dateTimeObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($dateTimeFilePathElement);
        
    }
    
    public function build() {
        
        $uuidElement = 'ca3497a0-b00b-11e3-a5e2-0800200c9a66';
        $usernameElement = 'rogercyr';
        $createdOnTimestampElement = time() - (24 * 60 * 60);
        $lastUpdatedOnTimestampElement = time();
        
        $role = $this->roleHelper->build();
        
        $uuid = $this->uuidObjectsData['adapter']->convertElementToUuid($uuidElement);
        $username = $this->stringObjectsData['adapter']->convertElementToPrimitive($usernameElement);
        $createdOn = $this->dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($createdOnTimestampElement);
        $lastUpdatedOn = $this->dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($lastUpdatedOnTimestampElement);
        
        return $this->objectsData['builderfactory']->create()
                                                    ->create()
                                                    ->withUuid($uuid)
                                                    ->withUsername($username)
                                                    ->withRole($role)
                                                    ->createdOn($createdOn)
                                                    ->lastUpdatedOn($lastUpdatedOn)
                                                    ->now();
    }
}