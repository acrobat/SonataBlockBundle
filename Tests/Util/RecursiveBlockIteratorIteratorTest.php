<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\BlockBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Sonata\BlockBundle\Util\RecursiveBlockIteratorIterator;

class RecursiveBlockIteratorIteratorTest extends TestCase
{
    public function testInterface()
    {
        $block2 = $this->createMock('Sonata\BlockBundle\Model\BlockInterface');
        $block2->expects($this->any())->method('getType')->will($this->returnValue('block2'));
        $block2->expects($this->once())->method('hasChildren')->will($this->returnValue(false));

        $block3 = $this->createMock('Sonata\BlockBundle\Model\BlockInterface');
        $block3->expects($this->any())->method('getType')->will($this->returnValue('block3'));
        $block3->expects($this->once())->method('hasChildren')->will($this->returnValue(false));

        $block1 = $this->createMock('Sonata\BlockBundle\Model\BlockInterface');
        $block1->expects($this->any())->method('getType')->will($this->returnValue('block1'));
        $block1->expects($this->once())->method('hasChildren')->will($this->returnValue(true));
        $block1->expects($this->any())->method('getChildren')->will($this->returnValue([
            $block2,
            $block3,
        ]));

        $block4 = $this->createMock('Sonata\BlockBundle\Model\BlockInterface');
        $block4->expects($this->any())->method('getType')->will($this->returnValue('block4'));
        $block4->expects($this->any())->method('hasChildren')->will($this->returnValue(false));

        $i = new RecursiveBlockIteratorIterator([$block1, $block4]);

        $blocks = [];
        foreach ($i as $block) {
            $blocks[] = $block;
        }

        $this->assertCount(4, $blocks);
    }
}
