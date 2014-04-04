<?php
namespace ConcreteUsers\Tests\Tests\Unit\Objects;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Strings\Tests\Helpers\StringHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use ConcreteUsers\Infrastructure\Objects\ConcreteUser;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;
use Primitives\Tests\Helpers\PrimitiveAdapterHelper;
use Users\Domain\Users\Exceptions\CannotRequestHasRoleException;

final class ConcreteUserTest extends \PHPUnit_Framework_TestCase {
    
    private $uuidMock;
    private $integerMock;
    private $stringMock;
    private $dateTimeMock;
    private $roleMock;
    private $booleanAdapterMock;
    private $booleanMock;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $usernameElement;
    private $emptyUsernameElement;
    private $booleanAdapterHelper;
    private $dateTimeHelper;
    private $stringHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->stringMock = $this->getMock('Strings\Domain\Strings\String');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->roleMock = $this->getMock('Roles\Domain\Roles\Role');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->booleanMock = $this->getMock('Booleans\Domain\Booleans\Boolean');
        
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->usernameElement = 'roger';
        $this->emptyUsernameElement = '';
        
        $this->booleanAdapterHelper = new PrimitiveAdapterHelper($this, $this->booleanAdapterMock);
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->stringHelper = new StringHelper($this, $this->stringMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
    }
    
    public function tearDown() {
        
    }
    
    public function testCreate_Success() {
        
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_Success($this->booleanMock, false);
        
        $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock);
        
        $this->assertEquals($this->uuidMock, $user->getUuid());
        $this->assertEquals($this->stringMock, $user->getUsername());
        $this->assertEquals($this->dateTimeMock, $user->createdOn());
        $this->assertNull($user->lastUpdatedOn());
        $this->assertEquals($this->booleanMock, $user->hasRole());
        $this->assertNull($user->getRole());
        
        $this->assertTrue($user instanceof \Users\Domain\Users\User);
        $this->assertTrue($user instanceof \ConcreteEntities\Infrastructure\Objects\AbstractEntity);
        
    }
    
    public function testCreate_withEmptyUsername_throwsCannotCreateEntityException() {
        
        $this->stringHelper->expectsGet_Success($this->emptyUsernameElement);
        
        $asserted = false;
        try {
        
            new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock);
            
        } catch (CannotCreateEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testCreate_withRole_Success() {
        
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_Success($this->booleanMock, true);
        
        $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, null, $this->roleMock);
        
        $this->assertEquals($this->uuidMock, $user->getUuid());
        $this->assertEquals($this->stringMock, $user->getUsername());
        $this->assertEquals($this->dateTimeMock, $user->createdOn());
        $this->assertNull($user->lastUpdatedOn());
        $this->assertEquals($this->booleanMock, $user->hasRole());
        $this->assertEquals($this->roleMock, $user->getRole());
        
        $this->assertTrue($user instanceof \Users\Domain\Users\User);
        $this->assertTrue($user instanceof \ConcreteEntities\Infrastructure\Objects\AbstractEntity);
        
    }
    
    public function testCreate_withRole_callsHasRole_throwsCannotConvertElementToPrimitiveException_throwsCannotRequestHasRoleException() {
        
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_throwsCannotConvertElementToPrimitiveException(true);
        
        $asserted = false;
        try {
        
            $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, null, $this->roleMock);
            $user->hasRole();
            
        } catch (CannotRequestHasRoleException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testCreate_withLastUpdatedOn_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->createdOnTimestampElement, $this->lastUpdatedOnTimestampElement));
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_Success($this->booleanMock, false);
        
        $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->assertEquals($this->uuidMock, $user->getUuid());
        $this->assertEquals($this->stringMock, $user->getUsername());
        $this->assertEquals($this->dateTimeMock, $user->createdOn());
        $this->assertEquals($this->dateTimeMock, $user->lastUpdatedOn());
        $this->assertEquals($this->booleanMock, $user->hasRole());
        $this->assertNull($user->getRole());
        
    }
    
    public function testCreate_withLastUpdatedOn_withRole_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->createdOnTimestampElement, $this->lastUpdatedOnTimestampElement));
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_Success($this->booleanMock, true);
        
        $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock, $this->roleMock);
        
        $this->assertEquals($this->uuidMock, $user->getUuid());
        $this->assertEquals($this->stringMock, $user->getUsername());
        $this->assertEquals($this->dateTimeMock, $user->createdOn());
        $this->assertEquals($this->dateTimeMock, $user->lastUpdatedOn());
        $this->assertEquals($this->booleanMock, $user->hasRole());
        $this->assertEquals($this->roleMock, $user->getRole());
        
    }
    
}