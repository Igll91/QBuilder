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

  Scenario: Get valid integer value
    Given that function i want to use is "getIntOrEx"
    When I try to get value "3214"
    Then I should get 3214

  Scenario: Get invalid integer value
    Given that function i want to use is "getIntOrEx"
    When I try to get value "ccasd"
    Then I should get error "InvalidArgumentException"

  Scenario: Get valid positive integer value
    Given that function i want to use is "getPositiveIntOrEx"
    When I try to get value "122"
    Then I should get 122

  Scenario: Get invalid positive integer value
    Given that function i want to use is "getPositiveIntOrEx"
    When I try to get value "-122"
    Then I should get error "InvalidArgumentException"

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

  Scenario: Get valid positive numeric value as string
    Given that function i want to use is "getPositiveNumericOrEx"
    When I try to get value "12"
    Then I should get 12

  Scenario: Get valid positive numeric value
    Given that function i want to use is "getPositiveNumericOrEx"
    When I try to get value 12312321
    Then I should get 12312321

  Scenario: Get invalid positive numeric value
    Given that function i want to use is "getPositiveNumericOrEx"
    When I try to get value 0
    Then I should get error "InvalidArgumentException"

  Scenario: Get invalid positive numeric value
    Given that function i want to use is "getPositiveNumericOrEx"
    When I try to get value -123
    Then I should get error "InvalidArgumentException"

  Scenario: Get valid string value
    Given that function i want to use is "getStringOrEx"
    When I try to get value "12321"
    Then I should get "12321"

  Scenario: Get invalid string value
    Given that function i want to use is "getStringOrEx"
    When I try to get integer value 123
    Then I should get error "InvalidArgumentException"

  Scenario: Get valid Time value
    Given that function i want to use is "getTimeOrEx"
    When I try to get value "23:59"
    Then I should get valid DateTime object

  Scenario: Get valid Time value
    Given that function i want to use is "getTimeOrEx"
    When I try to get value "23:59:59"
    Then I should get valid DateTime object

  Scenario: Get valid Time value
    Given that function i want to use is "getTimeOrEx"
    When I try to get value "3:59"
    Then I should get valid DateTime object

  Scenario: Get invalid Time value
    Given that function i want to use is "getTimeOrEx"
    When I try to get value "24:59"
    Then I should get error "InvalidArgumentException"

  Scenario: Get invalid Time value
    Given that function i want to use is "getTimeOrEx"
    When I try to get value "14:69"
    Then I should get error "InvalidArgumentException"

  Scenario: Get invalid Time value
    Given that function i want to use is "getTimeOrEx"
    When I try to get value "14:49:66"
    Then I should get error "InvalidArgumentException"