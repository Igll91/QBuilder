@helper @valuechecker
Feature: ValueChecker
  In order to check if value is of certain type
  As an application user
  I need to get that value or receive InvalidArgumentException

  Scenario: Get valid numeric integer value
    Given that function i want to use is "getNumericOrEx"
    When I try to get value 25
    Then I should get 25

  Scenario: Get valid numeric integer value passed as string
    Given that function i want to use is "getNumericOrEx"
    When I try to get value "3214"
    Then I should get 3214

  Scenario: Get valid numeric float value
    Given that function i want to use is "getNumericOrEx"
    When I try to get value 25.21421
    Then I should get 25.21421

  Scenario: Get valid negative numeric float value
    Given that function i want to use is "getNumericOrEx"
    When I try to get value -25.21421
    Then I should get -25.21421

  Scenario: Get invalid numeric value
    Given that function i want to use is "getNumericOrEx"
    When I try to get value "sad"
    Then I should get error "InvalidArgumentException"

