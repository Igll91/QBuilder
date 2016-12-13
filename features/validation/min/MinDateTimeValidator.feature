@validation
Feature: MinDateTimeValidator
  In order to validate allowed minimal DateTime
  As an application user
  I need to check whether given DateTime occurred after or during allowed
  If so it should return true

  Scenario: Validating DateTime before minimal
    Given that minimal allowed value for "MinDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-01 00:00:00+00:00" of type "DateTime"
    Then validation should return false

  Scenario: Validating DateTime before minimal with time precision
    Given that minimal allowed value for "MinDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-04 23:59:59+00:00" of type "DateTime"
    Then validation should return false

  Scenario: Validating DateTime equal to minimal
    Given that minimal allowed value for "MinDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-05 00:00:00+00:00" of type "DateTime"
    Then validation should return true

  Scenario: Validating DateTime after minimal
    Given that minimal allowed value for "MinDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-02-01 00:00:00+00:00" of type "DateTime"
    Then validation should return true

  Scenario: Validating DateTime after minimal with time precision
    Given that minimal allowed value for "MinDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-05 00:00:01+00:00" of type "DateTime"
    Then validation should return true

  Scenario: Passed invalid argument for validation
    Given that minimal allowed value for "MinDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "Invalid string value"
    Then I should get error "InvalidArgumentException"