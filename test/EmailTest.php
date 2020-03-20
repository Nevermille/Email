<?php namespace Lianhua\Email\Test;

use PHPUnit\Framework\ExpectationFailedException;
use \Lianhua\Email\Email;
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
 * @file Email.php
 * @author Camille Nevermind
 */

/**
 * @class EmailTest
 * @package Lianhua\Email\Test
 * @brief All tests for Email
 */
class EmailTest extends TestCase
{
    /**
     * @brief Tests all basic setters and getters
     * @return void
     * @throws ExpectationFailedException
     */
    public function testSimpleGettersAndSetters()
    {
        $email = new Email();

        $email->setMessage("Lorem Ipsum Sit Dolor Amet");
        $this->assertEquals("Lorem Ipsum Sit Dolor Amet", $email->getMessage());

        $email->setAlternateContent("Nullam vulputate sed ante nec blandit");
        $this->assertEquals("Nullam vulputate sed ante nec blandit", $email->getAlternateContent());
    }

    /**
     * @brief Tests attachments system
     * @return void
     * @throws ExpectationFailedException
     */
    public function testAttachments()
    {
        $email = new Email();

        $this->assertEquals(Email::NO_ERRORS, $email->addAttachement(__FILE__));
        $this->assertEquals(Email::ERROR_FILE_NOT_FOUND, $email->addAttachement("faibaufiabfaue"));
        $this->assertEquals(Email::ERROR_FILE_IS_DIRECTORY, $email->addAttachement(__DIR__));
        $this->assertEquals([__FILE__], $email->getAttachments());

        $email->clearAttachments();
        $this->assertEmpty($email->getAttachments());
    }
}
