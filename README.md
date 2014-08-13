Cashflows PHP API Library
=========================

PHP library for communicating with Cashflows' API, by [Nosco Systems](https://noscosystems.com).

Example Usage
-------------

```php
<?php

    use Nosco\Cashflows\Client as CashflowsClient;

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
    // Request Exceptions (validation, connectivity, 400 status codes, etc):
    catch(Nosco\Cashflows\Exceptions\ValidationException $e) {}
    catch(Nosco\Cashflows\Exceptions\TransportException $e) {}
    // Any other non-caught request exceptions.
    catch(Nosco\Cashflows\Exceptions\RequestException $e) {}
    // Response Exceptions (invalid requests, errors, blocked/declined, etc):
    catch(Nosco\Cashflows\Exceptions\Response\InvalidResponseException $e) {}
    catch(Nosco\Cashflows\Exceptions\Response\NotAuthorised\AuthorisationBlockedException $e) {}
    catch(Nosco\Cashflows\Exceptions\Response\NotAuthorised\AuthorisationDeclinedException $e) {}
    catch(Nosco\Cashflows\Exceptions\Response\NotAuthorisedException $e) {}
    catch(Nosco\Cashflows\Exceptions\ResponseException $e) {}
    catch(Nosco\Cashflows\Exceptions\CashflowsSystemException $e) {}
    // Cashflows catch-all exception:
    catch(Nosco\Cashflows\Exceptions\Exception $e) {}
```
