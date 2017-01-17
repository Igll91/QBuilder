@helper @json
Feature: JsonHelperContext
  In order to decode json
  As an application user
  I need to get that decoded value and proper process status

  Scenario: Decode valid json
    Given that I try to decode value '{"json" : ["this is json", "abc"]}'
    Then status should be successful

  Scenario: Decode invalid json
    Given that I try to decode value 'asd'
    Then status should be empty

  Scenario: Decode invalid json
    Given that I try to decode value '{d>d":sd}'
    Then status should be empty
