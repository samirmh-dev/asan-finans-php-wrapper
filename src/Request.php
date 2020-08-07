<?php

namespace AsanFinance;

use AsanFinance\Controllers\BaseRequest;
use AsanFinance\Exceptions\BadRequestException;
use AsanFinance\Exceptions\ValidationException;

class Request extends BaseRequest {

    /**
     * Get all possible information of person by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getAllPersonInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/PersonalInfo/All/$fin");
    }

    /**
     * Get current balance information
     *
     * @param string $startTimeStamp
     * @param string $endTimeStamp
     *
     * @throws \AsanFinance\Exceptions\BadRequestException
     * @return string
     */
    public function getBalanceInfo(string $startTimeStamp, string $endTimeStamp) : string {
        if($startTimeStamp >= $endTimeStamp) throw new BadRequestException('Start timestamp must be before End timestamp');

        if(!$this->isTimestamp($startTimeStamp)) {
            throw new BadRequestException('Start timestamp isn\'t correct');
        }

        if(!$this->isTimestamp($endTimeStamp)) {
            throw new BadRequestException('End timestamp isn\'t correct');
        }

        return $this->send('api/v1/balance', [
            'StartDate' => date('Y-m-d H:i:s',$startTimeStamp),
            'EndDate'   => date('Y-m-d H:i:s',$endTimeStamp)
        ], 'post');
    }

    /**
     * Get DMX information by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getDmxInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/DMXInfo/$fin");
    }

    /**
     * Get current and inactive employee information by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getEmployeeInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/EmployeeInfo/$fin");
    }

    /**
     * Get Farming information by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getFarmInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/FarmInfo/Pin/$fin");
    }

    /**
     * Get Farming information by TaxPayerNumber
     *
     * @param string $taxPayerNumber
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getFarmInfoByTaxPayerNumber(string $taxPayerNumber) : string {
        if(empty($taxPayerNumber)) throw new ValidationException('Tax payer number isn\'t correct.');

        return $this->send("api/v1/FarmInfo/Voen/$taxPayerNumber");
    }

    /**
     * Get Legal person information by his/her/its TaxPayerNumber
     *
     * @param string $taxPayerNumber
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getLegalPersonInfoByTaxPayerNumber(string $taxPayerNumber) : string {
        if(empty($taxPayerNumber)) throw new ValidationException('Tax payer number isn\'t correct.');

        return $this->send("api/v1/VoenInfo/$taxPayerNumber");
    }

    /**
     * Get international passport information by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getPassportInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/ForeignPassportInfo/$fin");
    }

    /**
     * Get pension information by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getPensionInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/PensionInfo/All/$fin");
    }

    /**
     * Get some personal information by FIN
     *
     * @param string $fin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getPersonInfoByFin(string $fin) : string {
        if(empty($fin) || strlen($fin) < 7) throw new ValidationException('FIN must contain 7 or more symbols.');

        return $this->send("api/v1/PersonalInfo/$fin");
    }

    /**
     * Get foreign person info by his/her VIN
     *
     * @param string $vin
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getPersonInfoByVin(string $vin) : string {
        if(empty($vin)) throw new ValidationException('VIN isn\'t correct.');

        return $this->send("api/v1/VINInfo/$vin");
    }

    /**
     * Get QHT information by TaxPayerNumber
     *
     * @param string $taxPayerNumber
     *
     * @throws \AsanFinance\Exceptions\ValidationException
     * @return string
     */
    public function getQhtInfoByTaxPayerNumber(string $taxPayerNumber) : string {
        if(empty($taxPayerNumber)) throw new ValidationException('Tax payer number isn\'t correct.');

        return $this->send("api/v1/QHT/Contracts/$taxPayerNumber");
    }

}