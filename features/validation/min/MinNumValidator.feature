@validation
Feature: MinNumValidator
  In order to validate allowed minimal numeric value
  As an application user
  I need to compare value with the defined validator rule minimal value

  Scenario: Validating smaller integer
    Given that minimal allowed value for "MinNumValidator" is 10
    When I try to validate value 9
    Then validation should return false

  Scenario: Validating smaller float
    Given that minimal allowed value for "MinNumValidator" is 10.02
    When I try to validate value 10.01
    Then validation should return false

  Scenario: Validating equal integer
    Given that minimal allowed value for "MinNumValidator" is 10
    When I try to validate value 10
    Then validation should return true

  Scenario: Validating equal float
    Given that minimal allowed value for "MinNumValidator" is 10.02
    When I try to validate value 10.02
    Then validation should return true

  Scenario: Validating bigger integer
    Given that minimal allowed value for "MinNumValidator" is 2
    When I try to validate value 5555
    Then validation should return true

  Scenario: Validating bigger float
    Given that minimal allowed value for "MinNumValidator" is 2.123
    When I try to validate value 5555
    Then validation should return true

  Scenario: Passed invalid minimal numeric value
    Given that minimal allowed invalid value for "MinNumValidator" is "a23"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed invalid validation parameter
    Given that minimal allowed value for "MinNumValidator" is "505"
    When I try to validate value 'c'
    Then I should get error "InvalidArgumentException"
