Feature: Toodledo
  Implement two use cases 
  Signup a new user
  And Add a new Task


  Scenario: Sign Up new user
    Given there is a website "https://www.toodledo.com/signup.php"
    When I fill field "email" with value "g10-mts@mts1617.com"
    When I fill field "pass1" with value "admin321"
    When I fill field "pass2" with value "admin321"
    When I check field "#terms"
    When I click button "#register"
    Then I should have content "g10"
    And close connection

  Scenario: Add a new Task
    Given there is a website "https://www.toodledo.com/signin.php"
    When I fill field "email" with value "g10-mts@mts1617.com"
    When I fill field "pass" with value "admin321"
    When I submit form "form"
    Then I should have content "g10"
    Given there is a website "https://www.toodledo.com/tasks/index.php"
    When I press button "nav_add"
    When I fill field "title" with value "test-task"
    When I submit form "form#formAddTask"
    Given there is a website "https://www.toodledo.com/tasks/index.php"
    Then I should have content "test-task"
    And close connection