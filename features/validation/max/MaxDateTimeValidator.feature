Feature: MaxDateTimeValidator
  In order to validate allowed maximal DateTime
  As an application user
  I need to check whether given DateTime occurred before or during allowed
  If so it should return true

  Scenario: Validating DateTime before maximal
    Given that maximal allowed value for "MaxDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-01 00:00:00+00:00" of type "DateTime"
    Then validation should return true

  Scenario: Validating DateTime before maximal with time precision
    Given that maximal allowed value for "MaxDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-04 23:59:59+00:00" of type "DateTime"
    Then validation should return true

  Scenario: Validating DateTime equal to maximal
    Given that maximal allowed value for "MaxDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-05 00:00:00+00:00" of type "DateTime"
    Then validation should return true

  Scenario: Validating DateTime after maximal
    Given that maximal allowed value for "MaxDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-02-01 00:00:00+00:00" of type "DateTime"
    Then validation should return false

  Scenario: Validating DateTime after maximal with time precision
    Given that maximal allowed value for "MaxDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "2000-01-05 00:00:01+00:00" of type "DateTime"
    Then validation should return false

  Scenario: Passed invalid argument for validation
    Given that maximal allowed value for "MaxDateTimeValidator" is "2000-01-05 00:00:00+00:00" of type "DateTime"
    When I try to validate value "Invalid string value"
    Then I should get error "InvalidArgumentException"
