@model
Feature: FilterTypeFeature
  In order to validate filter type
  As an application user
  I need to check if the value corresponds with expected filter type

  Scenario: Validating DoubleFilterType
    Given that we use "DoubleFilterType"
    When I try to validate value "asd"
    Then I should get "false"

  Scenario: Validating DoubleFilterType
    Given that we use "DoubleFilterType"
    When I try to validate value "213"
    Then I should get "true"

  Scenario: Validating DoubleFilterType
    Given that we use "DoubleFilterType"
    When I try to validate value "23.23"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate boolean value
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate non boolean value
    Then I should get "false"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "true"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "false"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "1"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "0"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "yes"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "no"
    Then I should get "true"

  Scenario: Validating BooleanFilterType
    Given that we use "BooleanFilterType"
    When I try to validate value "true it is"
    Then I should get "false"

  Scenario: Validating StringFilterType
    Given that we use "StringFilterType"
    When I try to validate boolean value
    Then I should get "false"

  Scenario: Validating StringFilterType
    Given that we use "StringFilterType"
    When I try to validate value "string"
    Then I should get "true"

  Scenario: Validating IntegerFilterType
    Given that we use "IntegerFilterType"
    When I try to validate value "string"
    Then I should get "false"

  Scenario: Validating IntegerFilterType
    Given that we use "IntegerFilterType"
    When I try to validate value "12.12"
    Then I should get "false"

  Scenario: Validating IntegerFilterType
    Given that we use "IntegerFilterType"
    When I try to validate value "505"
    Then I should get "true"

  Scenario: Validating TimeFilterType
    Given that we use "TimeFilterType"
    When I try to validate value "22:00:00"
    Then I should get "true"

  Scenario: Validating TimeFilterType
    Given that we use "TimeFilterType"
    When I try to validate value "asd"
    Then I should get "false"

  Scenario: Validating DateFilterType
    Given that we use "DateFilterType"
    When I try to validate value "2000-01-05"
    Then I should get "true"

  Scenario: Validating DateFilterType
    Given that we use "DateFilterType"
    When I try to validate value "200asd"
    Then I should get "false"

  Scenario: Validating DateTimeFilter
    Given that we use "DateTimeFilterType"
    When I try to validate value "2000-01-05 00:00:00"
    Then I should get "true"

  Scenario: Validating DateTimeFilterType
    Given that we use "DateTimeFilterType"
    When I try to validate value "2000-01-05"
    Then I should get "false"