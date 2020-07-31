![Image of social preview](https://user-images.githubusercontent.com/54883542/89041200-07d0e400-d356-11ea-9176-bf70a748d7f6.png)

# Asan Finans wrapper

[![Latest Stable Version](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/v/stable)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)
[![License](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/license)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)

[![Total Downloads](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/downloads)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)
[![Monthly Downloads](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/d/monthly)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)
[![Daily Downloads](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/d/daily)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)

[![composer.lock](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/composerlock)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)
[![Latest Unstable Version](https://poser.pugx.org/samirmh-dev/asan-finans-php-wrapper/v/unstable)](https://packagist.org/packages/samirmh-dev/asan-finans-php-wrapper)

### Possible Methods

````php
# Get all possible information of person by FIN
public function getPersonInfoByFin(string $fin) : string;

# Get current balance information
public function getEmployeeInfoByFin(string $fin) : string;

# Get DMX information by FIN
public function getBalanceInfo(string $startTimeStamp, string $endTimeStamp) : string;

# Get current and inactive employee information by FIN
public function getPassportInfoByFin(string $fin) : string;

# Get Farming information by FIN
public function getDmxInfoByFin(string $fin) : string;

# Get Farming information by TaxPayerNumber
public function getLegalPersonInfoByTaxPayerNumber(string $taxPayerNumber) : string;

# Get Legal person information by his/her/its TaxPayerNumber
public function getPersonInfoByVin(string $vin) : string;

# Get international passport information by FIN
public function getAllPersonInfoByFin(string $fin) : string;

# Get pension information by FIN
public function getPensionInfoByFin(string $fin) : string;

# Get some personal information by FIN
public function getFarmInfoByFin(string $fin) : string;

# Get foreign person info by his/her VIN
public function getFarmInfoByTaxPayerNumber(string $taxPayerNumber) : string;

# Get QHT information by TaxPayerNumber
public function getQhtInfoByTaxPayerNumber(string $taxPayerNumber) : string;
````

### Usage

Example:

First replace `ASAN_FINANCE_KEY` and `ASAN_FINANCE_BASE_URI` with your credentials. You can leave other fields as is.

````php
define("ASAN_FINANCE_KEY", '[KEY_FROM_ASAN]');
define('ASAN_FINANCE_DEBUG', FALSE);
define('ASAN_FINANCE_BASE_URI', '[BASE_URL_FROM_ASAN]');
define('ASAN_FINANCE_REQUEST_TIMEOUT', 2.0);
define('ASAN_FINANCE_VERIFY_SSL_PEER', FALSE);

$handler = new \AsanFinance\Request();

$info = $handler->getPersonInfoByFin('XXXXXXX');
````

### Fail and Success callbacks

You can pass your own function to run when requests fails or run when request is success.

````php
$fail = function($request, $response){
    // run some DB queries or something else
    //
    // $request -> request sent to Asan (array)
    // $response -> response given by Asan (array)
};

$success = function($request, $response){
    // run some DB queries or something else
    //
    // $request -> request sent to Asan (array)
    // $response -> response given by Asan (array)
};

$handler = new \AsanFinance\Request($fail, $success);

$info = $handler->getPersonInfoByFin('XXXXXXX');
````

or if you want to use inline (not recommended)

````php
$handler = new \AsanFinance\Request(function($request, $response){
                                     // run some DB queries or something else
                                     //
                                     // $request -> request sent to Asan (array)
                                     // $response -> response given by Asan (array)
                                 }, function($request, $response){
                                        // run some DB queries or something else
                                        //
                                        // $request -> request sent to Asan (array)
                                        // $response -> response given by Asan (array)
                                });

$info = $handler->getPersonInfoByFin('XXXXXXX');
````

or if you use wrapper on some class. You can't access `$request` and `$response` variables on this method.

````php
class AlphaClass {
    public function alpha(){
        $handler = new \AsanFinance\Request($this->failed(), $this->done());

        $info = $handler->getPersonInfoByFin('XXXXXXX');
    }

    public function failed(){
        // ...
    }

    public function done(){
        // ...
    }
}
````

If you want to pass only success callback:

````php
$success = function($request, $response){
    // run some DB queries or something else
    //
    // $request -> request sent to Asan (array)
    // $response -> response given by Asan (array)
};

$handler = new \AsanFinance\Request(null, $success);

$info = $handler->getPersonInfoByFin('XXXXXXX');
````

Example:

````php
$fail = function($request, $response){
    var_dump($request, $response);
};

$handler = new \AsanFinance\Request($fail);

$info = $handler->getPersonInfoByFin('XXXXXXX');
````

You will get response something like this:

````php
# don't pay attention to this response. I just used `var_dump`. Use can use any operation you want.
array(1) {
  ["fin"]=>
  string(7) "XXXXXXX"
}
array(2) {
  ["code"]=>
  int(404)
  ["body"]=>
  string(9) "Not found"
}

# don't pay attention to this response. This is just example
{"code":400,"success":false,"message":"Missing `RequestIdentifier` key on response"}
````