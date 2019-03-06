<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/19/2018
 * Time: 8:50 PM
 */

namespace Models;

use PDO;

class Subscriber
{
    public $pdo;

    public $mId;
    public $mEmail;
    public $mFirstName;
    public $mLastName;
    public $mMobileNumber;
    public $mZipCode;
    public $mDateJoin;
    public $mActive = 0;
    public $mError = 0;
    public $mValidated = 0;
    public $mStop = 0;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId() {
        return $this->mId;
    }

    public function getEmail()
    {
        return $this->mEmail;
    }
    public function getFirstName()
    {
        return $this->mFirstName;
    }
    public function getLastName()
    {
        return $this->mLastName;
    }
    public function getMobileNumber()
    {
        return Subscriber::stripE164($this->mMobileNumber);
    }
    public function getZipCode()
    {
        return $this->mZipCode;
    }
    public function getActive() {
        return $this->mActive;
    }

    public function setEmail($email)
    {
        $this->mEmail = $email;
    }
    public function setFirstName($firstName)
    {
        $this->mFirstName = $firstName;
    }
    public function setLastName($lastName)
    {
        $this->mLastName = $lastName;
    }
    public function setMobileNumber($number) {
        $this->mMobileNumber = Subscriber::numberE164($number);
    }
    public function setZipCode($zipCode)
    {
        $this->mZipCode = $zipCode;
    }
    public function setActive($isActive) {
        $this->mActive = $isActive;
    }
    public function setError($isError) {
        $this->mError = $isError;
    }

    // static constructor for client module
    public static function newFromClient($pdo, $inputs) {

        $sub = new Subscriber($pdo);
        $sub->mEmail = $inputs["email"];
        $sub->mFirstName = $inputs["firstName"];
        $sub->mLastName = $inputs["lastName"];
        $sub->setMobileNumber($inputs["mobileNumber"]);
        $sub->mZipCode = $inputs["zipCode"];

        return $sub;
    }

    // database processes
    public function create() {

        $stmt = $this->pdo->prepare('INSERT INTO subscribers(FIRST_NAME, LAST_NAME, MOBILE_NUMBER, EMAIL, ZIP_CODE, ACTIVE, VALIDATED, ERROR, STOP) VALUES (:firstName, :lastName, :mobileNumber, :email, :zipCode, :active, :validated, :error, :stop)');
        $stmt->execute([
            'firstName' => $this->mFirstName,
            'lastName' => $this->mLastName,
            'mobileNumber' => $this->mMobileNumber,
            'email' => $this->mEmail,
            'zipCode' => $this->mZipCode,
            'active' => $this->mActive,
            'validated' => $this->mValidated,
            'error' => $this->mError,
            'stop' => $this->mStop
        ]);
        $this->mId = $this->pdo->lastInsertId();
    }
    public function read($id) {

        $stmt = $this->pdo->prepare('SELECT ID as mId, EMAIL as mEmail, FIRST_NAME as mFirstName, LAST_NAME as mLastName, 
 MOBILE_NUMBER as mMobileNumber, ZIP_CODE as mZipCode, DATE_JOIN as mDateJoin, ACTIVE as mActive, VALIDATED as mValidated, ERROR as mError, STOP as mStop FROM subscribers WHERE ID = :id');
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_INTO, $this);
        $subscriber = $stmt->fetch();

        if (!$subscriber) {
            throw new \Exception("Subscriber not found.");
            exit();
        }
    }
    public function update() {

        $stmt = $this->pdo->prepare('UPDATE subscribers SET FIRST_NAME=:firstName,LAST_NAME=:lastName,MOBILE_NUMBER=:mobileNumber,EMAIL=:email,ZIP_CODE=:zipCode,ACTIVE=:active,ERROR=:error WHERE ID=:id');
        $stmt->execute([
            'firstName' => $this->mFirstName,
            'lastName' => $this->mLastName,
            'mobileNumber' => $this->mMobileNumber,
            'email' => $this->mEmail,
            'zipCode' => $this->mZipCode,
            'active' => $this->mActive,
            'error' => $this->mError,
            'id' => $this->mId
        ]);
    }

    public function readByMobile($mobile) {

        $stmt = $this->pdo->prepare('SELECT ID as mId, EMAIL as mEmail, FIRST_NAME as mFirstName, LAST_NAME as mLastName, 
 MOBILE_NUMBER as mMobileNumber, ZIP_CODE as mZipCode, DATE_JOIN as mDateJoin, ACTIVE as mActive, VALIDATED as mValidated, ERROR as mError, STOP as mStop FROM subscribers WHERE MOBILE_NUMBER = :mobileNumber');
        $stmt->execute(['mobileNumber' => Subscriber::numberE164($mobile)]);
        $stmt->setFetchMode(PDO::FETCH_INTO, $this);
        $subscriber = $stmt->fetch();

        if (!$subscriber) {
            throw new \Exception("Subscriber not found.");
            exit();
        }
    }

    public static function readAllActive($pdo) {

        $stmt = $pdo->prepare('SELECT ID as id, FIRST_NAME as firstName, LAST_NAME as lastName, MOBILE_NUMBER as mobileNumber, EMAIL as email, ZIP_CODE as zipCode, DATE_JOIN as dateJoin FROM subscribers WHERE ACTIVE = :active ORDER BY ID DESC');
        $stmt->execute(['active' => 1]);
        $subscribers = $stmt->fetchAll();
        return $subscribers;
    }
    public static function readAllActiveNumbers($pdo) {

        $stmt = $pdo->prepare('SELECT MOBILE_NUMBER FROM subscribers WHERE ACTIVE = :active');
        $stmt->execute(['active' => 1]);
        $subscribers = $stmt->fetchAll();
        return $subscribers;
    }
    public static function readAllAdminNumbers($pdo) {

        $stmt = $pdo->query('SELECT MOBILE_NUMBER FROM admin_users');
        $subscribers = $stmt->fetchAll();
        return $subscribers;
    }

    // checks if mobile number is subscribed already
    public static function exists($pdo, $mobile) {

        $stmt = $pdo->prepare('SELECT ACTIVE FROM subscribers WHERE MOBILE_NUMBER=:mobileNumber');
        $stmt->execute(['mobileNumber' => Subscriber::numberE164($mobile)]);
        $active = $stmt->fetchColumn();

        return $active;
    }


    //  converts to E.164 international format for twilio
    // numbers are formatted [+] [country code] [subscriber number including area code] and can have a maximum of fifteen digits
    public static function numberE164($number)
    {
        $number = str_replace("-", "", $number);
        return "+1" . $number;
    }

    public static function stripE164($number)
    {
        $number = str_replace("+1", "", $number);
        $number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $number);
        return $number;
    }
}
