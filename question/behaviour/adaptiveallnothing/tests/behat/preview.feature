@qbehaviour @qbehaviour_adaptiveallnothing
Feature: Preview a Multiple choice question with Adaptive all or nothing behaviour
  As a teacher
  In order to check my questions will work with Adaptive all or nothing behaviour
  I need to preview them with Adaptive all or nothing

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email               |
      | teacher1 | T1        | Teacher1 | teacher1@moodle.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course       | C1        | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype       | name             | template    |
      | Test questions   | multichoice | Multi-choice-001 | two_of_four |

  @javascript @_switch_window
  Scenario: Preview a Multiple choice question and submit a partially correct response.
    When I am on the "Multi-choice-001" "core_question > preview" page logged in as "teacher1"
    And I expand all fieldsets
    And I set the field "How questions behave" to "Adaptive mode (all or nothing)"
    And I press "Start again with these options"
    And I click on "One" "text"
    And I click on "Two" "text"
    And I press "Check"
    Then I should see "Mark 0.00 out of 1.00"
    And I switch to the main window

  @javascript @_switch_window
  Scenario: Preview a Multiple choice question and submit a correct response.
    When I am on the "Multi-choice-001" "core_question > preview" page logged in as "teacher1"
    And I expand all fieldsets
    And I set the field "How questions behave" to "Adaptive mode (all or nothing)"
    And I press "Start again with these options"
    And I click on "One" "text"
    And I click on "Three" "text"
    And I press "Check"
    Then I should see "Mark 1.00 out of 1.00"
    And I switch to the main window
