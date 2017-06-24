<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Employee
 *
 * @author NexX
 */
class Employee {
    private $EmployeeID;
    private $PersonID;
    private $DepartmentID;
    private $EntryDate;
    private $TerminationDate;
    private $SocialSecurityNumber;
    private $Person_FirstName;
    private $Person_LastName;
    
    function __construct($EmployeeID, $PersonID, $DepartmentID, $EntryDate, $TerminationDate, $SocialSecurityNumber, $Person_FirstName, $Person_LastName) {
        $this->EmployeeID = $EmployeeID;
        $this->PersonID = $PersonID;
        $this->DepartmentID = $DepartmentID;
        $this->EntryDate = $EntryDate;
        $this->TerminationDate = $TerminationDate;
        $this->SocialSecurityNumber = $SocialSecurityNumber;
        $this->Person_FirstName = $Person_FirstName;
        $this->Person_LastName = $Person_LastName;
    }
    function getEmployeeID() {
        return $this->EmployeeID;
    }

    function getPersonID() {
        return $this->PersonID;
    }

    function getDepartmentID() {
        return $this->DepartmentID;
    }

    function getEntryDate() {
        return $this->EntryDate;
    }

    function getTerminationDate() {
        return $this->TerminationDate;
    }

    function getSocialSecurityNumber() {
        return $this->SocialSecurityNumber;
    }

    function getPerson_FirstName() {
        return $this->Person_FirstName;
    }

    function getPerson_LastName() {
        return $this->Person_LastName;
    }

    function setEmployeeID($EmployeeID) {
        $this->EmployeeID = $EmployeeID;
    }

    function setPersonID($PersonID) {
        $this->PersonID = $PersonID;
    }

    function setDepartmentID($DepartmentID) {
        $this->DepartmentID = $DepartmentID;
    }

    function setEntryDate($EntryDate) {
        $this->EntryDate = $EntryDate;
    }

    function setTerminationDate($TerminationDate) {
        $this->TerminationDate = $TerminationDate;
    }

    function setSocialSecurityNumber($SocialSecurityNumber) {
        $this->SocialSecurityNumber = $SocialSecurityNumber;
    }

    function setPerson_FirstName($Person_FirstName) {
        $this->Person_FirstName = $Person_FirstName;
    }

    function setPerson_LastName($Person_LastName) {
        $this->Person_LastName = $Person_LastName;
    }
}
