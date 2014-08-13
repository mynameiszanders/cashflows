Cashflows PHP API Library
=========================

PHP library for communicating with Cashflows' API, by [Nosco Systems](https://noscosystems.com).

Example Usage
-------------

```php
<?php

    use Nosco\Cashflows\Client as CashflowsClient;

    CashflowsClient::setTransport(new Nosco\Cashflows\Transport\Guzzle);
    $cashflows = new CashflowsClient;
    $request = $cashflows->paymentRequest();
    $request->fields = [
        'auth_id' => 1234,
        'auth_pass' => 'p@55w0rd',
        'card_num' => '1234567890123456',
        'card_cvv' => '123',
        'card_expiry' => new \Date('2017-03'),
        ...
    ];

    try {
        $response = $request->send();
        var_dump($response);

        # object(Nosco\Response)[1]
        #   public 'transactionId' => string '01S00001722' (length=11)
        #   public 'cvvCheck' => int 2
        #   public 'addressCheck' => int 3
        #   public 'postcodeCheck' => int 2
        #   public 'authCode' => string '031971' (length=6)

    }
    // Request Exceptions (validation, connectivity, 400 status codes, etc):
    catch(Nosco\Cashflows\Exceptions\ValidationException $e) {}
    catch(Nosco\Cashflows\Exceptions\InvalidRequestException $e) {}
    catch(Nosco\Cashflows\Exceptions\TransportException $e) {}
    // Any other non-caught request exceptions.
    catch(Nosco\Cashflows\Exceptions\RequestException $e) {}
    // Response Exceptions (invalid requests, errors, blocked/declined, etc):
    // NB. AuthorisationBlocked is an extension of NotAuthorised.
    catch(Nosco\Cashflows\Exceptions\AuthorisationBlockedException $e) {}
    catch(Nosco\Cashflows\Exceptions\NotAuthorisedException $e) {}
    catch(Nosco\Cashflows\Exceptions\CashflowsSystemException $e) {}
    // Any other non-caught response exceptions.
    catch(Nosco\Cashflows\Exceptions\ResponseException $e) {}
    // Cashflows catch-all exception:
    catch(Nosco\Cashflows\Exceptions\Exception $e) {}
```
