<?php

namespace Doctrine\Tests\Common\Persistence;

use BadMethodCallException;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\ReflectionService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\PersistentObject;
use Doctrine\Tests\DoctrineTestCase;
use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionClass;
use RuntimeException;
use stdClass;
use function count;
use function in_array;

/**
 * @group DDC-1448
 */
class PersistentObjectTest extends DoctrineTestCase
{
    /** @var TestObjectMetadata */
    private $cm;

    /** @var ObjectManager|PHPUnit_Framework_MockObject_MockObject */
    private $om;

    /** @var TestObject */
    private $object;

    public function setUp()
    {
        $this->cm = new TestObjectMetadata();
        $this->om = $this->createMock(ObjectManager::class);
        $this->om->expects($this->any())->method('getClassMetadata')
                 ->will($this->returnValue($this->cm));
        $this->object = new TestObject();
        PersistentObject::setObjectManager($this->om);
        $this->object->injectObjectManager($this->om, $this->cm);
    }

    public function testGetObjectManager()
    {
        self::assertSame($this->om, PersistentObject::getObjectManager());
    }

    public function testNonMatchingObjectManager()
    {
        $this->expectException(RuntimeException::class);
        $om = $this->createMock(ObjectManager::class);
        $this->object->injectObjectManager($om, $this->cm);
    }

    public function testGetField()
    {
        self::assertSame('beberlei', $this->object->getName());
    }

    public function testSetField()
    {
        $this->object->setName('test');
        self::assertSame('test', $this->object->getName());
    }

    public function testGetIdentifier()
    {
        self::assertSame(1, $this->object->getId());
    }

    public function testSetIdentifier()
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->setId(2);
    }

    public function testSetUnknownField()
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->setUnknown('test');
    }

    public function testGetUnknownField()
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->getUnknown();
    }

    public function testUndefinedMethod()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('There is no method');
        (new TestObject())->undefinedMethod();
    }

    public function testGetToOneAssociation()
    {
        self::assertNull($this->object->getParent());
    }

    public function testSetToOneAssociation()
    {
        $parent = new TestObject();
        $this->object->setParent($parent);
        self::assertSame($parent, $this->object->getParent($parent));
    }

    public function testSetInvalidToOneAssociation()
    {
        $parent = new stdClass();

        $this->expectException(InvalidArgumentException::class);
        $this->object->setParent($parent);
    }

    public function testSetToOneAssociationNull()
    {
        $parent = new TestObject();
        $this->object->setParent($parent);
        $this->object->setParent(null);
        self::assertNull($this->object->getParent());
    }

    public function testAddToManyAssociation()
    {
        $child = new TestObject();
        $this->object->addChildren($child);

        self::assertSame($this->object, $child->getParent());
        self::assertSame(1, count($this->object->getChildren()));

        $child = new TestObject();
        $this->object->addChildren($child);

        self::assertSame(2, count($this->object->getChildren()));
    }

    public function testAddInvalidToManyAssociation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->addChildren(new stdClass());
    }

    public function testNoObjectManagerSet()
    {
        PersistentObject::setObjectManager(null);
        $child = new TestObject();

        $this->expectException(RuntimeException::class);
        $child->setName('test');
    }

    public function testInvalidMethod()
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->asdf();
    }

    public function testAddInvalidCollection()
    {
        $this->expectException(BadMethodCallException::class);
        $this->object->addAsdf(new stdClass());
    }
}

class TestObjectMetadata implements ClassMetadata
{
    public function getAssociationMappedByTargetField($assocName)
    {
        $assoc = ['children' => 'parent'];
        return $assoc[$assocName];
    }

    public function getAssociationNames()
    {
        return ['parent', 'children'];
    }

    public function getAssociationTargetClass($assocName)
    {
        return __NAMESPACE__ . '\TestObject';
    }

    public function getFieldNames()
    {
        return ['id', 'name'];
    }

    public function getIdentifier()
    {
        return ['id'];
    }

    public function getName()
    {
        return __NAMESPACE__ . '\TestObject';
    }

    public function getReflectionClass()
    {
        return new ReflectionClass($this->getName());
    }

    public function getTypeOfField($fieldName)
    {
        $types = ['id' => 'integer', 'name' => 'string'];
        return $types[$fieldName];
    }

    public function hasAssociation($fieldName)
    {
        return in_array($fieldName, ['parent', 'children']);
    }

    public function hasField($fieldName)
    {
        return in_array($fieldName, ['id', 'name']);
    }

    public function isAssociationInverseSide($assocName)
    {
        return $assocName === 'children';
    }

    public function isCollectionValuedAssociation($fieldName)
    {
        return $fieldName === 'children';
    }

    public function isIdentifier($fieldName)
    {
        return $fieldName === 'id';
    }

    public function isSingleValuedAssociation($fieldName)
    {
        return $fieldName === 'parent';
    }

    public function getIdentifierValues($entity)
    {
    }

    public function getIdentifierFieldNames()
    {
    }

    public function initializeReflection(ReflectionService $reflService)
    {
    }

    public function wakeupReflection(ReflectionService $reflService)
    {
    }
}
