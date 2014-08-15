Cashflows PHP API Library
=========================

PHP library for communicating with Cashflows' API, for [Nosco Systems](https://noscosystems.com) by [Zander Baldwin](https://github.com/mynameiszanders), version `1.0.0-RC1`.

Available API Requests
----------------------

Although each request object can be instantiated stand-alone from its respective class, it's easier to create it through
a dedicated method in the Client (`Nosco\Cashflows\Client`) object - which automatically sets the Auth ID and password
for each request.

The available dedicated methods, and their corresponding request classes, are:

| Dedicated Method                       | Request Object Class                                                        |
|----------------------------------------|-----------------------------------------------------------------------------|
|`paymentRequest`                        | `Nosco\Cashflows\Request\Payment`.                                          |
|`mobilePaymentRequest`                  | `Nosco\Cashflows\Request\Payment\Mobile`.                                   |
|`continuousPaymentRequest`              | `Nosco\Cashflows\Request\Payment\Continuous`.                               |
|`alternativeRecurringPaymentRequest`    | `Nosco\Cashflows\Request\Payment\AlternativeRecurring`.                     |
|`voidRequest`                           | `Nosco\Cashflows\Request\Void`.                                             |
|`refundRequest`                         | `Nosco\Cashflows\Request\Refund`.                                           |
|`verificationRequest`                   | `Nosco\Cashflows\Request\Verification`.                                     |

Sending Requests
----------------

Each request object has a set of attributes that must be filled-in before the request can be sent, and these are
documented in Cashflows' *Remote API Integration Guide* (version 1.7 April 2014).

The attributes can be entered using the `attribute()` method of the request object, and the API call can be sent with
the `send()` method. Once an API call is successful, an `Nosco\Cashflows\Response\Authorised` response object is
returned from the `send()` method.

Catching Errors
---------------

The following is the Exception tree; only exception classes in leaf nodes are thrown, all others are for group-catching.
All exceptions are prefixed with the namespace `Nosco\Cashflows\Exceptions`.

- `BaseException` **never** thrown (group-catch only).
  - `Validation`.
  - `Transport`.
  - `CashflowsSystem`.
  - `Response` **never** thrown (group-catch only).
    - `Response\InvalidResponse`.
    - `Response\NotAuthorised` **never** thrown (group-catch only).
      - `Response\NotAuthorised\Blocked`.
      - `Response\NotAuthorised\Cancelled`.
      - `Response\NotAuthorised\Declined`.
      - `Response\NotAuthorised\InvalidRequest`.

Example Usage
-------------

```php
<?php

    use Nosco\Cashflows\Client as CashflowsClient;
    use Nosco\Cashflows\Exceptions as Error;

    $cashflows = new CashflowsClient('authorisation_id', 'p@55w0rd');
    $request = $cashflows->paymentRequest();
    $request->attributes([
        'card_num' => '1234567890123452',
        'card_cvv' => '123',
        'card_expiry' => '0317',
        ...
    ]);

    try {
        $response = $request->send();
        var_dump($response);

        # object(Nosco\Cashflows\Response\Authorised)[1]
        #   protected 'transactionId' => string '01S00001722' (length=11)
        #   protected 'cvvCheck' => int 2
        #   protected 'addressCheck' => int 3
        #   protected 'postcodeCheck' => int 2
        #   protected 'authCode' => string '031971' (length=6)

    }

    // Catch any errors that occur before or during the API call to Cashflows (request exceptions):
    catch(Error\Validation $e) {}
    catch(Error\Transport $e) {}

    // Catch any errors that occur after the API call to Cashflows (response exceptions):
    # You can use the Error\Response\NotAuthorisedException to cover the first four, or Error\ResponseException to
    # cover all five.
    catch(Error\Response\NotAuthorised\Blocked $e) {}
    catch(Error\Response\NotAuthorised\Cancelled $e) {}
    catch(Error\Response\NotAuthorised\Declined $e) {}
    catch(Error\Response\NotAuthorised\InvalidRequest $e) {}
    catch(Error\Response\InvalidResponse $e) {}

    // Catch any errors that Cashflows had:
    catch(Error\System $e) {}

    // Catch any other errors that happened within the library during the API call:
    # You can just use this catch block to catch everything, without any of the above catch blocks.
    catch(Error\BaseException $e) {}
```
