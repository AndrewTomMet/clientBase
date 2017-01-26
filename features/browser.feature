Feature: browser

  Scenario: Navigate to login
    Given I am on "/login"
    When the response status code should be 200
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/"

  Scenario: Navigate to languages
    Given I am on "/lang"
    Then I should be on "/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/lang"

  Scenario: Navigate to category types
    Given I am on "/contacttype"
    Then I should be on "/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/contacttype"

  Scenario: Navigate to home
    Given I am on "/"
    Then I should be on "/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/"

  Scenario: Navigate to admin
    Given I am on "/admin"
    Then I should be on "/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/admin"
