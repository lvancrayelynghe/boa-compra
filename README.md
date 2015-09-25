# Unofficial BoaCompra billing PHP library

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/Benoth/boa-compra.svg?style=flat-square)](https://travis-ci.org/Benoth/boa-compra)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/Benoth/boa-compra.svg?style=flat-square)](https://scrutinizer-ci.com/g/Benoth/boa-compra/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/Benoth/boa-compra.svg?style=flat-square)](https://scrutinizer-ci.com/g/Benoth/boa-compra)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d6070e0b-2008-42b7-a2ed-e7189815fd91/mini.png)](https://insight.sensiolabs.com/projects/d6070e0b-2008-42b7-a2ed-e7189815fd91)

This package is compliant with [PSR-1], [PSR-2] and [PSR-4]. If you notice compliance oversights,
please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

## Requirements

The following versions of PHP are supported:

* PHP 5.4
* PHP 5.5
* PHP 5.6
* HHVM

The following extensions are also required:

* curl
* mbstring


## Usage

### Create a payment

``` php
$vsi = new VirtualStoreIdentification($yourStoreId, $yourSecretKey);

try {
    $endUser = new EndUser('me@example.com');
    $endUser->setName('John Doe')
            // ...
            ->setLanguage('en_US');

    $payment = new Payment(
        $vsi,
        $endUser,
        $yourReturnUrl,
        $yourNotifyUrl,
        $yourCurrencyIso,
        $yourOrderId,
        $orderDescription,
        $amount // without dot or comma (ie: 500 for $5.00)
    );
    $payment->setTestMode(1)
            ->setProjectId(1)
            ->setPaymentId(1);
} catch (\Exception $e) {
	// Log or anything ...
}

$form = new PaymentFormGenerator($payment);

// Then in your HTML code, just call :
$form->render();
```

### Validate BoaCompra notification
``` php
try {
    // $payment is your previously set Payment object
	$notif = new PaymentNotification(
	    $payment,
	    $_POST['store_id'],
	    $_POST['transaction_id'],
	    $_POST['order_id'],
	    $_POST['amount'],
	    $_POST['currency_code'],
	    $_POST['payment_id'],
	    $_SERVER['REMOTE_ADDR']
	);
	$postback = new PaymentPostBack($notif);
	$postback->validatePayment();
	return 'Ok !';
} catch (\Exception $e) {
	return 'Error validating the payment : '.$e->getMessage();
}
```

### Check the status of a payment
``` php
try {
	$notif = new PaymentNotification(
	    $payment,
	    $storeId,
	    $transactionId,
	    $orderId,
	    $amount,
	    $currencyCode,
	    $paymentId
	);
	$status = new PaymentCheckStatus($notif);
	$status->validatePayment();
	return 'Ok !';
} catch (\Exception $e) {
	return 'Error validating the payment : '.$e->getMessage();
}
```

## API

The API documentation is available on [Github Pages](http://benoth.github.io/boa-compra/api/Benoth/BoaCompra.html)


## Testing

``` bash
$ vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/Benoth/boa-compra/blob/master/LICENSE) for more information.
