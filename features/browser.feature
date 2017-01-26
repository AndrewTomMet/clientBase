Feature: browser

  Scenario: Navigate to login
    Given I am on "http://localhost/app_dev.php/login"
    When the response status code should be 200
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "http://localhost/app_dev.php/"

  Scenario: Navigate to languages
    Given I am on "http://localhost/app_dev.php/lang"
    Then I should be on "http://localhost/app_dev.php/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "http://localhost/app_dev.php/lang"

  Scenario: Navigate to category types
    Given I am on "http://localhost/app_dev.php/contacttype"
    Then I should be on "http://localhost/app_dev.php/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "http://localhost/app_dev.php/contacttype"

  Scenario: Navigate to home
    Given I am on "http://localhost/app_dev.php/"
    Then I should be on "http://localhost/app_dev.php/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "http://localhost/app_dev.php/"

  Scenario: Navigate to admin
    Given I am on "http://localhost/app_dev.php/admin"
    Then I should be on "http://localhost/app_dev.php/login"
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "http://localhost/app_dev.php/admin/dashboard"
