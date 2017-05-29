Feature: RelationHolderFactory
    In order to extract entity relations from ConditionOperatorValueHolder
    As an application user
    I need to parse relation string combinations
    And return proper valid structure

    Scenario: No relations in ConditionOperatorValueHolder
        Given that used ConditionOperatorValueHolder is "without relations"
        When I extract relation field identifiers
        Then I should get array '[]'
        And RelationHolder should contain relations with corresponding keys

    Scenario: Single relation in ConditionOperatorValueHolder
        Given that used ConditionOperatorValueHolder is "single relation"
        When I extract relation field identifiers
        Then I should get array '["relationone"]'
        And RelationHolder should contain relations with corresponding keys

    Scenario: Two same relations in ConditionOperatorValueHolder
        Given that used ConditionOperatorValueHolder is "two same relations"
        When I extract relation field identifiers
        Then I should get array '["relationone"]'
        And RelationHolder should contain relations with corresponding keys

    Scenario: Two different relations in ConditionOperatorValueHolder
        Given that used ConditionOperatorValueHolder is "two different relations"
        When I extract relation field identifiers
        Then I should get array '["relationone", "relationtwo"]'
        And RelationHolder should contain relations with corresponding keys

    Scenario: Multiple multy layered relations in ConditionOperatorValueHolder
        Given that used ConditionOperatorValueHolder is "multitple multilayered"
        When I extract relation field identifiers
        Then I should get array '["relationone", "relationtwo", "relationthree"]'
        And RelationHolder should contain relations with corresponding keys
        # TODO: INSERT TESTS FOR key1.key2.key3. multi relations...

