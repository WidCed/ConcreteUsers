<?php
namespace ConcreteUsers\Tests\Tests\Unit\Builders;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Strings\Tests\Helpers\StringHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use ConcreteUsers\Infrastructure\Builders\ConcreteUserBuilder;
use ObjectLoaders\Tests\Helpers\ObjectLoaderAdapterHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderHelper;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteUserBuilderTest extends \PHPUnit_Framework_TestCase {
    
    private $objectLoaderAdapterMock;
    private $objectLoaderMock;
    private $uuidMock;
    private $integerMock;
    private $stringMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $userMock;
    private $classNameElement;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $builder;
    private $objectLoaderAdapterHelper;
    private $objectLoaderHelper;
    private $dateTimeHelper;
    private $stringHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->objectLoaderAdapterMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter');
        $this->objectLoaderMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\ObjectLoader');
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->stringMock = $this->getMock('Strings\Domain\Strings\String');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->userMock = $this->getMock('Users\Domain\Users\User');
        
        $this->classNameElement = 'ConcreteUsers\Infrastructure\Objects\ConcreteUser';
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        
        $this->builder = new ConcreteUserBuilder($this->booleanAdapterMock, $this->objectLoaderAdapterMock);
        
        $this->objectLoaderAdapterHelper = new ObjectLoaderAdapterHelper($this, $this->objectLoaderAdapterMock);
        $this->objectLoaderHelper = new ObjectLoaderHelper($this, $this->objectLoaderMock);
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->stringHelper = new StringHelper($this, $this->stringMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testBuild_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->userMock, array($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock));
        
        $user = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withUsername($this->stringMock)
                                ->createdOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->userMock, $user);
        
    }
    
    public function testBuild_withoutUsername_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withLastUpdatedOn_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->userMock, array($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock));
        
        $user = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withUsername($this->stringMock)
                                ->createdOn($this->dateTimeMock)
                                ->lastUpdatedOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->userMock, $user);
        
    }
    
    public function testExtendsRightInterfaces_Success() {
        
        $this->assertTrue($this->builder instanceof \Users\Domain\Users\Builders\UserBuilder);
        
    }
    
    public function testExtendsRightClass_Success() {
        
        $this->assertTrue($this->builder instanceof \ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder);
        
    }
    
    public function testIsFinal_Success() {
        
        $reflectionClass = new \ReflectionClass($this->builder);
        $this->assertTrue($reflectionClass->isFinal());
        
    }
}