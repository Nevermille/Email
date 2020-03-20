<?php namespace Lianhua\Email\Test;

use Lianhua\Email\EmailAddress;
use PHPUnit\Framework\ExpectationFailedException;
use \PHPUnit\Framework\TestCase;

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
 * @file EmailAddressTest.php
 * @author Camille Nevermind
 */

/**
 * @class EmailTest
 * @package Lianhua\Email\Test
 * @brief All tests for Email
 */
class EmailAddressTest extends TestCase
{
    /**
     * @brief Tests the constructor
     * @return void
     * @throws ExpectationFailedException
     */
    public function testConstructor()
    {
        $address = new EmailAddress("nevermille@lianhua.dev", "Camille Nevermind");

        $this->assertEquals("Camille Nevermind", $address->getName());
        $this->assertEquals("nevermille@lianhua.dev", $address->getAddress());
    }

    /**
     * @brief Tests the setters and the getters
     * @return void
     * @throws ExpectationFailedException
     */
    public function testGettersAndSetters()
    {
        $address = new EmailAddress();
        $address->setName("Testuo Outset");
        $address->setAddress("test@google.com");

        $this->assertEquals("Testuo Outset", $address->getName());
        $this->assertEquals("test@google.com", $address->getAddress());
    }
}
