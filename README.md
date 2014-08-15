Cashflows PHP API Library
=========================

PHP library for communicating with Cashflows' API, for [Nosco Systems](https://noscosystems.com) by [Zander Baldwin](https://github.com/mynameiszanders), version `1.0.0-RC1`.

Example Usage
-------------

```php
<?php

    use Nosco\Cashflows\Client as CashflowsClient;
    use Nosco\Cashflows\Exceptions as Error;

    $cashflows = new CashflowsClient('authorisation_id', 'p@55w0rd');
    $request = $cashflows->paymentRequest();
    $request->attributes([
        'card_num' => '1234567890123456',
        'card_cvv' => '123',
        'card_expiry' => new \Date('2017-03'),
        ...
    ]);

    try {
        $response = $request->send();
        var_dump($response);

        # object(Nosco\Response)[1]
        #   protected 'transactionId' => string '01S00001722' (length=11)
        #   protected 'cvvCheck' => int 2
        #   protected 'addressCheck' => int 3
        #   protected 'postcodeCheck' => int 2
        #   protected 'authCode' => string '031971' (length=6)

    }

    // Catch any errors that occur before or during the API call to Cashflows (request exceptions):
    catch(Error\ValidationException $e) {}
    catch(Error\TransportException $e) {}

    // Catch any errors that occur after the API call to Cashflows (response exceptions):
    # You can use the Error\Response\NotAuthorisedException to cover the first four, or Error\ResponseException to
    # cover all five.
    catch(Error\Response\NotAuthorised\BlockedException $e) {}
    catch(Error\Response\NotAuthorised\CancelledException $e) {}
    catch(Error\Response\NotAuthorised\DeclinedException $e) {}
    catch(Error\Response\NotAuthorised\InvalidRequestException $e) {}
    catch(Error\Response\InvalidResponseException $e) {}

    // Catch any errors that Cashflows had:
    catch(Error\CashflowsSystemException $e) {}

    // Catch any other errors that happened within the library during the API call:
    # You can just use this catch block to catch everything, without any of the above catch blocks.
    catch(Error\BaseException $e) {}
```
