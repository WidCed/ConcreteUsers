<?php
namespace ConcreteUsers\Tests\Tests\Unit\Objects;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Strings\Tests\Helpers\StringHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use ConcreteUsers\Infrastructure\Objects\ConcreteUser;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;

final class ConcreteUserTest extends \PHPUnit_Framework_TestCase {
    
    private $uuidMock;
    private $integerMock;
    private $stringMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $usernameElement;
    private $emptyUsernameElement;
    private $dateTimeHelper;
    private $stringHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->stringMock = $this->getMock('Strings\Domain\Strings\String');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->usernameElement = 'roger';
        $this->emptyUsernameElement = '';
        
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->stringHelper = new StringHelper($this, $this->stringMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testCreate_Success() {
        
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        
        $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock);
        
        $this->assertEquals($this->uuidMock, $user->getUuid());
        $this->assertEquals($this->stringMock, $user->getUsername());
        $this->assertEquals($this->dateTimeMock, $user->createdOn());
        $this->assertNull($user->lastUpdatedOn());
        
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
    
    public function testCreate_withLastUpdatedOn_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->createdOnTimestampElement, $this->lastUpdatedOnTimestampElement));
        $this->stringHelper->expectsGet_Success($this->usernameElement);
        
        $user = new ConcreteUser($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->assertEquals($this->uuidMock, $user->getUuid());
        $this->assertEquals($this->stringMock, $user->getUsername());
        $this->assertEquals($this->dateTimeMock, $user->createdOn());
        $this->assertEquals($this->dateTimeMock, $user->lastUpdatedOn());
        
    }
    
}