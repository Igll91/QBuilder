@validation
Feature: MaxNumValidator
  In order to validate allowed maximal numeric value
  As an application user
  I need to compare value with the defined validator rule maximal value

  Scenario: Validating bigger integer
    Given that maximal allowed value for "MaxNumValidator" is 10
    When I try to validate value "12"
    Then validation should return false

  Scenario: Validating bigger float
    Given that maximal allowed value for "MaxNumValidator" is 10.02
    When I try to validate value "14.123"
    Then validation should return false

  Scenario: Validating equal integer
    Given that maximal allowed value for "MaxNumValidator" is 10
    When I try to validate value "10"
    Then validation should return true

  Scenario: Validating equal float
    Given that maximal allowed value for "MaxNumValidator" is 10.02
    When I try to validate value "10.02"
    Then validation should return true

  Scenario: Validating smaller integer
    Given that maximal allowed value for "MaxNumValidator" is 212
    When I try to validate value "1"
    Then validation should return true

  Scenario: Validating smaller float
    Given that maximal allowed value for "MaxNumValidator" is 20.123
    When I try to validate value "20.122"
    Then validation should return true

  Scenario: Passed invalid maximal numeric value
    Given that maximal allowed value for "MaxNumValidator" is "a23"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed invalid validation parameter
    Given that maximal allowed value for "MaxNumValidator" is "505"
    When I try to validate value "c"
    Then I should get error "InvalidArgumentException"