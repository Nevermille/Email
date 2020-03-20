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
 * @file EmailAddress.php
 * @author Camille Nevermind
 */

/**
 * @class EmailAddress
 * @package Lianhua\Email
 * @brief A class containing all parameters for email address
 */
class EmailAddress
{
    /**
     * @brief The name
     * @var string $name
     */
    protected $name;

    /**
     * @brief The address
     * @var string $address
     */
    protected $address;

    /**
     * @brief Sets the name
     * @param string $name The name
     * @return void
     */
    public function setName(string $name):void
    {
        $this->name = $name;
    }

    /**
     * @brief Returns the name
     * @return string The name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @brief Sets the address
     * @param string $address The address
     * @return void
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @brief Returns the address
     * @return string The address
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @brief The constructor
     * @param string $address The address
     * @param string $name The name
     * @return void
     */
    public function __construct($address = "", $name = "")
    {
        $this->name = $name;
        $this->address = $address;
    }
}
