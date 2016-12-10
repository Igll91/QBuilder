@validation
Feature: MinStringValidator
  In order to validate allowed minimal string length
  As an application user
  I need to compare length of given string with the defined validator rule minimal length
  If given string is equal or longer than minimal, it should return true

  Scenario: Validating smaller string
    Given that minimal allowed value for "MinStringValidator" is 10
    When I try to validate value "smaller"
    Then validation should return false

  Scenario: Validating string equal to the limit
    Given that minimal allowed value for "MinStringValidator" is 10
    When I try to validate value "abcdefgrty"
    Then validation should return true

  Scenario: Validating bigger string
    Given that minimal allowed value for "MinStringValidator" is 10
    When I try to validate value "abcdefgrtyabcdefgrtyabcdefgrtyabcdefgrty"
    Then validation should return true

  Scenario: Passed invalid format length limit
    Given that minimal allowed invalid value for "MinStringValidator" is "asd"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed negative length limit
    Given that minimal allowed invalid value for "MinStringValidator" is -1
    Then I should get error "InvalidArgumentException"

  Scenario: Passed zero as length limit
    Given that minimal allowed invalid value for "MinStringValidator" is 0
    Then I should get error "InvalidArgumentException"
