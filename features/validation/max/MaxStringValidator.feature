@validation
Feature: MaxStringValidator
  In order to validate allowed maximal string length
  As an application user
  I need to compare length of given string with the defined validator rule maximal length
  If given string is equal or shorter than maximal, it should return true

  Scenario: Validating longer string
    Given that maximal allowed value for "MaxStringValidator" is 10
    When I try to validate value "thisstringisbigger"
    Then validation should return false

  Scenario: Validating equal length string
    Given that maximal allowed value for "MaxStringValidator" is 4
    When I try to validate value "four"
    Then validation should return true

  Scenario: Validating shorter string
    Given that maximal allowed value for "MaxStringValidator" is 123
    When I try to validate value "four"
    Then validation should return true

  Scenario: Passed invalid format length limit
    Given that maximal allowed invalid value for "MaxStringValidator" is "asd"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed negative length limit
    Given that maximal allowed invalid value for "MaxStringValidator" is "-1"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed zero as length limit
    Given that maximal allowed invalid value for "MaxStringValidator" is 0
    Then I should get error "InvalidArgumentException"

