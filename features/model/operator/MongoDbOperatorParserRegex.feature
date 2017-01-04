@parser @operator
Feature: OperatorParser
  In order to check if given string corresponds to expected Operator
  As an application user
  I need to get that Operator or receive InvalidArgumentException

  Scenario: Get NotEndsWithOperator operator
    Given that value I want to parse is "(?<!asd)$"
    Then I should get "NotEndsWithOperator"

  Scenario: Get NotEndsWithOperator operator
    Given that value I want to parse is "(?<!asćčžđššqewasdžćd)$"
    Then I should get "NotEndsWithOperator"

  Scenario: Get NotBeginsWithOperator operator
    Given that value I want to parse is "^(?!asd)"
    Then I should get "NotBeginsWithOperator"

  Scenario: Get NotBeginsWithOperator operator
    Given that value I want to parse is "^(?!asćčžđššqewasdžćd)"
    Then I should get "NotBeginsWithOperator"

  Scenario: Get NotBeginsWithOperator operator
    Given that value I want to parse is "^(?!a213sćč32123žđššqewasdžćd)"
    Then I should get "NotBeginsWithOperator"

  Scenario: Get NotBeginsWithOperator operator
    Given that value I want to parse is "^(?!as#@@!!ćčžđššqewasdžćd)"
    Then I should get "NotBeginsWithOperator"

  Scenario: Get NotContainsOperator operator
    Given that value I want to parse is "^((?!asd).)*$"
    Then I should get "NotContainsOperator"

  Scenario: Get NotContainsOperator operator
    Given that value I want to parse is "^((?!p).)*$"
    Then I should get "NotContainsOperator"

  Scenario: Get NotContainsOperator operator
    Given that value I want to parse is "^((?!ćčlćčl32).)*$"
    Then I should get "NotContainsOperator"

  Scenario: Get NotContainsOperator operator
    Given that value I want to parse is "^((?!ŠĐ213čćl2141'?23).)*$"
    Then I should get "NotContainsOperator"

  Scenario: Get EndsWithOperator operator
    Given that value I want to parse is "asd$"
    Then I should get "EndsWithOperator"

  Scenario: Get EndsWithOperator operator
    Given that value I want to parse is "ćčl123asd$"
    Then I should get "EndsWithOperator"

  Scenario: Get EndsWithOperator operator
    Given that value I want to parse is "d$"
    Then I should get "EndsWithOperator"

  Scenario: Get EndsWithOperator operator
    Given that value I want to parse is "ŠŠĐžćčžćčđšp*?=)=?!#$asd$"
    Then I should get "EndsWithOperator"

  Scenario: Get ContainsOperator operator
    Given that value I want to parse is "asd"
    Then I should get "ContainsOperator"

  Scenario: Get ContainsOperator operator
    Given that value I want to parse is "asd!@"
    Then I should get "ContainsOperator"

  Scenario: Get ContainsOperator operator
    Given that value I want to parse is "asd"
    Then I should get "ContainsOperator"

  Scenario: Get ContainsOperator operator
    Given that value I want to parse is "asd$"
    Then I should get "ContainsOperator"

  Scenario: Get ContainsOperator operator
    Given that value I want to parse is "^asd"
    Then I should get "ContainsOperator"
