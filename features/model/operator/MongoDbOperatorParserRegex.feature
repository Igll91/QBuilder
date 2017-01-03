@parser @operator
Feature: OperatorParser
  In order to check if given string corresponds to expected Operator
  As an application user
  I need to get that Operator or receive InvalidArgumentException

  Scenario: Get NotEndsWithOperator operator
    Given that value I want to parse is "(?<!asd)$"
    Then I should get "NotEndsWithOperator"