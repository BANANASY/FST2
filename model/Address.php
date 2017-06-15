<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Address
 *
 * @author NexX
 */
class Address {
    private $addressID;
    private $address;
    private $zip;
    private $city;
    private $country;
    
    function __construct($addressID, $address, $zip, $city, $country) {
        $this->addressID = $addressID;
        $this->address = $address;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }

    
    function getAddressID() {
        return $this->addressID;
    }

    function getAddress() {
        return $this->address;
    }

    function getZip() {
        return $this->zip;
    }

    function getCity() {
        return $this->city;
    }

    function getCountry() {
        return $this->country;
    }

    function setAddressID($addressID) {
        $this->addressID = $addressID;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setZip($zip) {
        $this->zip = $zip;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setCountry($country) {
        $this->country = $country;
    }


    
}
