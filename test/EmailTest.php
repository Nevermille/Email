<?php namespace Lianhua\Email\Test;

/*
Email Library
Copyright (C) 2020  Lianhua Studio

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @file Email.php
 * @author Camille Nevermind
 */

/**
 * @class EmailTest
 * @package Lianhua\Email\Test
 * @brief All tests for Email
 */
class EmailTest extends \PHPUnit\Framework\TestCase
{
    public function testGettersAndSetters()
    {
        $email = new \Lianhua\Email\Email();

        $email->setMessage("Lorem Ipsum Sit Dolor Amet");
        $this->assertEquals("Lorem Ipsum Sit Dolor Amet", $email->getMessage());

        $email->setAlternateContent("Nullam vulputate sed ante nec blandit");
        $this->assertEquals("Nullam vulputate sed ante nec blandit", $email->getAlternateContent());
    }
}
