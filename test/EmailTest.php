<?php namespace Lianhua\Email\Test;

use PHPUnit\Framework\ExpectationFailedException;
use \Lianhua\Email\Email;
use Lianhua\Email\EmailAddress;
use PHPUnit\Framework\InvalidArgumentException;
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
 * @file EmailTest.php
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
        $this->assertCount(1, $email->getAttachments());
        $this->assertEquals([__FILE__], $email->getAttachments());

        $email->clearAttachments();
        $this->assertEmpty($email->getAttachments());
    }

    /**
     * @brief Test From address
     * @return void
     * @throws ExpectationFailedException
     */
    public function testFromAddress()
    {
        $email = new Email();

        $this->assertEquals(Email::NO_ERRORS, $email->setFrom(new EmailAddress("test@google.com")));
        $this->assertEquals("test@google.com", $email->getFrom()->getAddress());
        $this->assertEquals(Email::NO_ERRORS, $email->setFrom(new EmailAddress("test@google.con")));
        $this->assertEquals("test@google.con", $email->getFrom()->getAddress());
        $this->assertEquals(Email::NO_ERRORS, $email->setFrom(new EmailAddress("test@google.com", "Testuo Outset")));
        $this->assertEquals("test@google.com", $email->getFrom()->getAddress());
        $this->assertEquals(Email::ERROR_EMAIL_FORMAT, $email->setFrom(new EmailAddress("Whaou!")));
        $this->assertEquals("test@google.com", $email->getFrom()->getAddress());

        $email->setCheckDns(true);

        $this->assertEquals(Email::ERROR_EMAIL_DNS_CHECK, $email->setFrom(new EmailAddress("test@google.con")));
        $this->assertEquals("test@google.com", $email->getFrom()->getAddress());
    }

    /**
     * Tests "To", "Cc" and "Bcc" addresses
     * @return void
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testOtherAddresses()
    {
        $email = new Email();

        $this->assertEquals(Email::NO_ERRORS, $email->addTo(new EmailAddress("address1@lianhua.dev")));
        $this->assertCount(1, $email->getTo());
        $this->assertEquals("address1@lianhua.dev", $email->getTo()[0]->getAddress());
        $this->assertEquals(Email::ERROR_EMAIL_FORMAT, $email->addTo(new EmailAddress("address2.lianhua.dev")));
        $this->assertCount(1, $email->getTo());
        $this->assertEquals("address1@lianhua.dev", $email->getTo()[0]->getAddress());
        $this->assertEquals(Email::NO_ERRORS, $email->addTo(new EmailAddress("address3@lianhua.dev")));
        $this->assertCount(2, $email->getTo());
        $this->assertEquals("address1@lianhua.dev", $email->getTo()[0]->getAddress());
        $this->assertEquals("address3@lianhua.dev", $email->getTo()[1]->getAddress());
        $email->clearTo();
        $this->assertEmpty($email->getTo());

        $this->assertEquals(Email::NO_ERRORS, $email->addCc(new EmailAddress("address4@lianhua.dev")));
        $this->assertCount(1, $email->getCc());
        $this->assertEquals("address4@lianhua.dev", $email->getCc()[0]->getAddress());
        $this->assertEquals(Email::ERROR_EMAIL_FORMAT, $email->addCc(new EmailAddress("address5.lianhua.dev")));
        $this->assertCount(1, $email->getCc());
        $this->assertEquals("address4@lianhua.dev", $email->getCc()[0]->getAddress());
        $this->assertEquals(Email::NO_ERRORS, $email->addCc(new EmailAddress("address6@lianhua.dev")));
        $this->assertCount(2, $email->getCc());
        $this->assertEquals("address4@lianhua.dev", $email->getCc()[0]->getAddress());
        $this->assertEquals("address6@lianhua.dev", $email->getCc()[1]->getAddress());
        $email->clearCc();
        $this->assertEmpty($email->getCc());

        $this->assertEquals(Email::NO_ERRORS, $email->addBcc(new EmailAddress("address7@lianhua.dev")));
        $this->assertCount(1, $email->getBcc());
        $this->assertEquals("address7@lianhua.dev", $email->getBcc()[0]->getAddress());
        $this->assertEquals(Email::ERROR_EMAIL_FORMAT, $email->addBcc(new EmailAddress("address8.lianhua.dev")));
        $this->assertCount(1, $email->getBcc());
        $this->assertEquals("address7@lianhua.dev", $email->getBcc()[0]->getAddress());
        $this->assertEquals(Email::NO_ERRORS, $email->addBcc(new EmailAddress("address9@lianhua.dev")));
        $this->assertCount(2, $email->getBcc());
        $this->assertEquals("address7@lianhua.dev", $email->getBcc()[0]->getAddress());
        $this->assertEquals("address9@lianhua.dev", $email->getBcc()[1]->getAddress());
        $email->clearBcc();
        $this->assertEmpty($email->getBcc());
    }

    public function testHeaders()
    {
        $email = new Email();

        $email->addHeader("X-CUSTOM-H1", "VAL1");
        $email->addHeader("X-CUSTOM-H2", "VAL2");
        $email->addHeader("X-CUSTOM-H3", "VAL3");

        $headers = $email->getHeaders();

        $this->assertCount(3, $headers);
        $this->arrayHasKey("X-CUSTOM-H1", $headers);
        $this->arrayHasKey("X-CUSTOM-H2", $headers);
        $this->arrayHasKey("X-CUSTOM-H3", $headers);
        $this->assertEquals("VAL1", $headers["X-CUSTOM-H1"]);
        $this->assertEquals("VAL2", $headers["X-CUSTOM-H2"]);
        $this->assertEquals("VAL3", $headers["X-CUSTOM-H3"]);

        $email->clearHeaders();

        $this->assertEmpty($email->getHeaders());
    }
}
