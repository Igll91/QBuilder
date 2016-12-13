@validation
Feature: MaxTimeValidator
  In order to validate maximal allowed Time
  As an application user
  I need to check whether given Time occurred before or during allowed
  If so it should return true

  Scenario: Validating Time before maximal allowed
    Given that maximal allowed value for "MaxTimeValidator" is "14:00:00"
    When I try to validate value "13:59:59"
    Then validation should return true

  Scenario: Validating Time equal to maximal allowed
    Given that maximal allowed value for "MaxTimeValidator" is "14:00:00"
    When I try to validate value "14:00:00"
    Then validation should return true

  Scenario: Validating Time after maximal allowed
    Given that maximal allowed value for "MaxTimeValidator" is "14:00:00"
    When I try to validate value "14:00:01"
    Then validation should return false

  Scenario: Validating Time after maximal allowed
    Given that maximal allowed value for "MaxTimeValidator" is "00:00:00"
    When I try to validate value "23:59:59"
    Then validation should return false

  Scenario: Passed invalid maximal time value
    Given that maximal allowed invalid value for "MaxTimeValidator" is "25:00:00"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed invalid maximal time value
    Given that maximal allowed invalid value for "MaxTimeValidator" is "24:00:00"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed invalid validation parameter
    Given that maximal allowed value for "MaxTimeValidator" is "22:00:00"
    When I try to validate value 'c'
    Then I should get error "InvalidArgumentException"