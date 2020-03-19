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
 * This class have everything needed to store an email data.
 * I personally recommend to extend this class with a send function
 * to make sendings easier.
 */
class Email
{
    /**
     * @var string $from
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
     * @var string
     * It's recommended to set one alternate message for disabled people
     */
    protected $alternateContent;

    const ERROR_EMAIL_FORMAT = 1;
    const ERROR_DNS_CHECK = 2;

    /**
     * @brief Add an email address to the array after format checking
     * @param string $email The email address to add
     * @param array $dest The destination array
     * @return void
     */
    protected function addEmail(string $email, array &$dest)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dest[] = $email;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @brief Check DNS record for address
     * @param string $email The email address to check
     * @return bool True if correct, false otherwise
     */
    protected function checkDns(string $email)
    {
        // We extract address between < and >
        $exploded = explode("<", $email);
        $extracted = $exploded[count($exploded) - 1];
        $exploded = explode(">", $extracted);
        $extracted = $exploded[0];

        // We extract the domain after the @
        $domain = explode("@", $extracted);

        // Why idn_to_ascii: https://www.php.net/manual/fr/function.checkdnsrr.php#113537
        // Why a dot at the end of the domain: https://www.php.net/manual/fr/function.checkdnsrr.php#119969
        return checkdnsrr(idn_to_ascii($domain . ".", IDNA_DEFAULT));
    }

    /**
     * @brief Set up DNS check each time an address is added
     * @param bool $val The parameter value
     * @return void
     */
    public function setCheckDns(bool $val)
    {
        $this->checkDns = $val;
    }

    /**
     * @brief The constructor
     * @return void
     */
    public function __construct()
    {
        $this->from = "";
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->attachments = [];
        $this->checkDns = false;
        $this->message = "";
        $this->alternateContent = "";
    }
}
