@validation
Feature: MinTimeValidator
  In order to validate minimal allowed Time
  As an application user
  I need to check whether given Time occurred after or during allowed
  If so it should return true

  Scenario: Validating Time before minimal allowed
    Given that minimal allowed value for "MinTimeValidator" is "14:00:00"
    When I try to validate value "13:59:59"
    Then validation should return false

  Scenario: Validating Time equal to minimal allowed
    Given that minimal allowed value for "MinTimeValidator" is "14:00:00"
    When I try to validate value "14:00:00"
    Then validation should return true

  Scenario: Validating Time after minimal allowed
    Given that minimal allowed value for "MinTimeValidator" is "14:00:00"
    When I try to validate value "14:00:01"
    Then validation should return true

  Scenario: Validating Time after minimal allowed
    Given that minimal allowed value for "MinTimeValidator" is "00:00:00"
    When I try to validate value "23:59:59"
    Then validation should return true

  Scenario: Passed invalid minimal numeric value
    Given that minimal allowed invalid value for "MinTimeValidator" is "25:00:00"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed invalid minimal numeric value
    Given that minimal allowed invalid value for "MinTimeValidator" is "24:00:00"
    Then I should get error "InvalidArgumentException"

  Scenario: Passed invalid validation parameter
    Given that minimal allowed value for "MinTimeValidator" is "22:00:00"
    When I try to validate value 'c'
    Then I should get error "InvalidArgumentException"