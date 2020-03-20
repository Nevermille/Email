# Email

[![Build Status](https://travis-ci.com/Nevermille/Email.svg?branch=master)](https://travis-ci.com/Nevermille/Email) [![BCH compliance](https://bettercodehub.com/edge/badge/Nevermille/Email?branch=master)](https://bettercodehub.com/)

## Overview

A simple PHP class for email. Please keep in mind this library *doesn't* send mails, you have to extend these classes with a send function.

## Compatibility

This library has been tested for **PHP 7.3 and higher**

## Installation

Just use composer in your project:

```
composer require lianhua/email
```

If you don't use composer, clone or download this repository, all you need is inside the *src* directory.

## Usage
### Creating an email

You can create an email by using the constructor

```php
$email = new \Lianhua\Email\Email();
```

### Setting the message

You can set a TXT or a HTML message with a method. You can also set a special message for disabled people.

```php
// Set messages
$email->setMessage("Welcome!");
$email->setAlternateContent("Welcome, screen reader user");

// Get messages
$email->getMessage(); // "Welcome!"
$email->getAlternateContent(); // "Welcome, screen reader user"
```

### Addresses

You can set the addresses with Email methods by providing an EmailAddress object.

You can only have one "From" address but as many "To", "Cc" and "Bcc". The address format is checked before adding it.

```php
$address = new \Lianhua\Email\EmailAddress("address@example.com", "Recipient Name");

// Set addresses
$email->setFrom($address);
$email->addTo($address);
$email->addCc($address);
$email->addBcc($address);

// Get addresses
$email->getFrom() // $address
$email->getTo() // [$address]
$email->getCc() // [$address]
$email->getBcc() // [$address]
```

You can delete all addresses for "To", "Cc" and "Bcc" with the clear* functions

```php
$email->clearTo()
$email->clearCc()
$email->clearBcc()
```

### Attachements

You can add and delete attachments with Email methods. The file existence is checked before.

```php
// Add attachments
$email->addAttachment("/tmp/A.pdf");
$email->addAttachment("/tmp/B.pdf");

// Get attachments
$email->getAttachments(); // ["/tmp/A.pdf", "/tmp/B.pdf"]

// Delete attachments
$email->clearAttachments();
```

### Headers

You can set cutom headers

```php
// Add headers
$email->addHeader("X-HEADER", "WELCOME");
$email->addHeader("X-HEADER-2", "BIENVENUE");

// Get headers
$email->getHeaders() // ["X-HEADER" => "WELCOME", "X-HEADER-2" => "BIENVENUE"]

// Delete headers
$email->clearHeaders();
```

### Advanced
#### Check DNS

You can ask for a DNS MX record check before adding addresses.

```php
// Set parameter
$email->setCheckDns(true);

// Add address
$email->addTo(new \Lianhua\Email\EmailAddress("test@google.com")); // Valid
$email->addTo(new \Lianhua\Email\EmailAddress("test@google.con")); // Not valid
```

#### Return values

When you use an address function, you can see if the input address had been added

```php
$email->addTo(new \Lianhua\Email\EmailAddress("test@google.com")); // \Lianhua\Email\Email::NO_ERRORS
$email->addTo(new \Lianhua\Email\EmailAddress("test.google.com")); // \Lianhua\Email\Email::ERROR_EMAIL_FORMAT

// If you enabled DNS check
$email->addTo(new \Lianhua\Email\EmailAddress("test@google.con")); // \Lianhua\Email\Email::ERROR_EMAIL_DNS_CHECK
```

You can see if the attachment had been added too

```php
// Add attachments
$email->addAttachment("/tmp/A.pdf"); // \Lianhua\Email\Email::NO_ERRORS
$email->addAttachment("/tmp/kjbfkkqsd"); // \Lianhua\Email\Email::ERROR_FILE_NOT_FOUND
$email->addAttachment("/tmp"); // \Lianhua\Email\Email::ERROR_FILE_IS_DIRECTORY
```
