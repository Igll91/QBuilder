@condition @parser
Feature: RuleConditionOperatorValueHolderParser
  In order to receive IConditionOperatorValueHolderParser instance
  As an application user
  I need to parse given value and check if it corresponds to valid IConditionOperatorValueHolderParser

  Scenario: Validating AndConditionValueHolder
    Given that we use "RuleConditionOperatorValueHolderParser"
    And we try to parse value "AND"
    Then I should get AndConditionValueHolder

  Scenario: Validating OrConditionValueHolder
    Given that we use "RuleConditionOperatorValueHolderParser"
    And we try to parse value "OR"
    Then I should get OrConditionValueHolder

  Scenario: Case sensitive
    Given that we use "RuleConditionOperatorValueHolderParser"
    And we try to parse value "Or"
    Then I should get null

  Scenario: Trying to validate false value
    Given that we use "RuleConditionOperatorValueHolderParser"
    And we try to parse value "ORnotAnd"
    Then I should get null