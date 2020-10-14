<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Tests\Unit\Serializer;

use FOS\ElasticaBundle\Serializer\Callback;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class CallbackTest extends TestCase
{
    public function testSerializerMustHaveSerializeMethod()
    {
        $callback = new Callback();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The serializer must have a "serialize" method.');
        $callback->setSerializer(new \stdClass());
    }

    public function testSetGroupsWorksWithValidSerializer()
    {
        $callback = new Callback();
        $serializer = $this->createMock(SerializerInterface::class);
        $callback->setSerializer($serializer);

        $callback->setGroups(['foo']);
    }

    public function testSetGroupsFailsWithInvalidSerializer()
    {
        $callback = new Callback();
        $serializer = $this->createMock(FakeSerializer::class);
        $callback->setSerializer($serializer);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Setting serialization groups requires using "JMS\Serializer\Serializer" or "Symfony\Component\Serializer\Serializer"'
        );

        $callback->setGroups(['foo']);
    }
}

class FakeSerializer
{
    public function serialize()
    {
    }
}
