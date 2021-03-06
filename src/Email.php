<?php namespace Lianhua\Email;

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
 * @class Email
 * @package Lianhua\Email
 * @brief A class containing all parameters for email
 *
 * This class have everything needed to store an email data.
 * I personally recommend to extend this class with a send function
 * to make sendings easier.
 */
class Email
{
    /**
     * @var EmailAddress $from
     * @brief The from address
     */
    protected $from;

    /**
     * @var array $to
     * @brief A list of "To" emails
     */
    protected $to;

    /**
     * @var array $cc
     * @brief A list of "Cc" emails
     */
    protected $cc;

    /**
     * @var array $bcc
     * @brief A list of "Bcc" emails
     */
    protected $bcc;

    /**
     * @var array $attachements
     * @brief A list of attachments
     */
    protected $attachments;

    /**
     * @brief Parameter for DNS check
     * @var bool $checkDns
     */
    protected $checkDns;

    /**
     * @brief The message
     * @var string $message
     */
    protected $message;

    /**
     * @brief The alternate content
     * @var string $alternateContent
     *
     * It's recommended to set one alternate message for disabled people
     */
    protected $alternateContent;

    /**
     * @brief An array of custom headers
     * @var array $headers
     */
    protected $headers;

    /**
     * @brief The subject of the email
     * @var string $subject
     */
    protected $subject;

    /**
     * @brief The reply address of the email
     * @var EmailAddress $reply
     */
    protected $reply;

    const NO_ERRORS = 0;
    const ERROR_EMAIL_FORMAT = 1;
    const ERROR_EMAIL_DNS_CHECK = 2;
    const ERROR_FILE_NOT_FOUND = 3;
    const ERROR_FILE_IS_DIRECTORY = 4;

    /**
     * @brief Returns the subject of the email
     * @return string The subject of the email
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @brief Sets the subject of the email
     * @param string $subject The subject
     * @return void
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @brief Remove all headers
     * @return void
     */
    public function clearHeaders(): void
    {
        $this->headers = [];
    }

    /**
     * @brief Returns the array of headers
     * @return array The headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @brief Add a header to the mail
     * @param string $name The name of the header
     * @param string $value The value of the header
     * @return void
     *
     * If the header already exists, it'll be overwritten
     */
    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * @brief Remove all "Bcc" addresses
     * @return void
     */
    public function clearBcc():void
    {
        $this->bcc = [];
    }

    /**
     * @brief Returns the "Bcc" addresses
     * @return array The "Bcc" addresses
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * @brief Add an adress to the "Bcc" array
     * @param EmailAddress $address The address
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    public function addBcc(EmailAddress $address): int
    {
        return $this->addEmail($address, $this->bcc);
    }

    /**
     * @brief Remove all "Cc" addresses
     * @return void
     */
    public function clearCc():void
    {
        $this->cc = [];
    }

    /**
     * @brief Returns the "Cc" addresses
     * @return array The "Cc" addresses
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * @brief Add an adress to the "Cc" array
     * @param EmailAddress $address The address
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    public function addCc(EmailAddress $address): int
    {
        return $this->addEmail($address, $this->cc);
    }

    /**
     * @brief Remove all "To" addresses
     * @return void
     */
    public function clearTo():void
    {
        $this->to = [];
    }

    /**
     * @brief Returns the "To" addresses
     * @return array The "To" addresses
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @brief Add an adress to the "To" array
     * @param EmailAddress $address The address
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    public function addTo(EmailAddress $address): int
    {
        return $this->addEmail($address, $this->to);
    }

    /**
     * @brief Returns the Reply address
     * @return EmailAddress|null The Reply address
     */
    public function getReply(): ?EmailAddress
    {
        return $this->reply;
    }

    /**
     * @brief Sets the from address
     * @param EmailAddress $address The address
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    public function setReply(EmailAddress $address): int
    {
        return $this->setEmail($address, $this->reply);
    }

    /**
     * @brief Returns the From address
     * @return EmailAddress|null The From address
     */
    public function getFrom(): ?EmailAddress
    {
        return $this->from;
    }

    /**
     * @brief Sets the from address
     * @param EmailAddress $address The address
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    public function setFrom(EmailAddress $address): int
    {
        return $this->setEmail($address, $this->from);
    }

    /**
     * @brief Returns all attachments
     * @return array The attachments
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @brief Remove all attachments
     * @return void
     */
    public function clearAttachments(): void
    {
        $this->attachments = [];
    }

    /**
     * @brief Add an attachement
     * @param string $filepath The path of the fiche to attach
     * @return int One of the error codes ERROR_FILE_* or NO_ERRORS
     *
     * This function checks if the file exists and if it's not a directory
     */
    public function addAttachment(string $filepath): int
    {
        // Check file existence
        if (!file_exists($filepath)) {
            return self::ERROR_FILE_NOT_FOUND;
        }

        // Check if it's really a file
        if (is_dir($filepath)) {
            return self::ERROR_FILE_IS_DIRECTORY;
        }

        $this->attachments[] = $filepath;
        return self::NO_ERRORS;
    }

    /**
     * @brief Returns the alternate content
     * @return string The alternate content
     */
    public function getAlternateContent(): string
    {
        return $this->alternateContent;
    }

    /**
     * @brief Sets the alternate content
     * @param string $content The alternate content
     * @return void
     */
    public function setAlternateContent(string $content): void
    {
        $this->alternateContent = $content;
    }

    /**
     * @brief Returns the message
     * @return string The message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @brief Sets the message
     * @param string $message The message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @brief Check an email address
     * @param string $address The email address to check
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    protected function checkEmail(string $address): int
    {
        // Format check
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            return self::ERROR_EMAIL_FORMAT;
        }

        // DNS check if needed
        if ($this->checkDns && !$this->checkAddressDns($address)) {
            return self::ERROR_EMAIL_DNS_CHECK;
        }

        return self::NO_ERRORS;
    }

    /**
     * @brief Add an email address to an array after checks
     * @param string $address The email address to add
     * @param array $dest The destination array
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    protected function addEmail(EmailAddress $address, array &$dest): int
    {
        $res = $this->checkEmail($address->getAddress());

        if ($res == self::NO_ERRORS) {
            $dest[] = $address;
        }

        return $res;
    }

    /**
     * @brief Set an email address to a var after checks
     * @param string $address The email address to add
     * @param mixed $dest The destination array
     * @return int One of error codes ERROR_EMAIL_* or NO_ERRORS
     */
    protected function setEmail(EmailAddress $address, &$dest): int
    {
        $res = $this->checkEmail($address->getAddress());

        if ($res == self::NO_ERRORS) {
            $dest = $address;
        }

        return $res;
    }

    /**
     * @brief Check DNS record for address
     * @param string $address The email address to check
     * @return bool True if correct, false otherwise
     */
    protected function checkAddressDns(string $address): bool
    {
        // We extract the domain after the @
        $domain = explode("@", $address)[1];

        // Why a dot at the end of the domain: https://www.php.net/manual/fr/function.checkdnsrr.php#119969
        return checkdnsrr($domain . ".");
    }

    /**
     * @brief Set up DNS check each time an address is added
     * @param bool $val The parameter value
     * @return void
     */
    public function setCheckDns(bool $val): void
    {
        $this->checkDns = $val;
    }

    /**
     * @brief The constructor
     * @return void
     */
    public function __construct()
    {
        $this->from = null;
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->attachments = [];
        $this->checkDns = false;
        $this->message = "";
        $this->alternateContent = "";
        $this->headers = [];
        $this->subject = "";
        $this->reply = null;
    }
}
