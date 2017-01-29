Feature: Stack methods
  Working with Stack Methods
  Implement methods push, pop, top


  Scenario: Adding element to stack
    Given there is a stack
    When I add subject "Math"
    When I add subject "Physic"
    When I add subject "Chemistry"
    When I remove an elemenet from stack
    Then I should have "Physic" at top of stack
    When I remove an elemenet from stack
    And the stack has 1 element
