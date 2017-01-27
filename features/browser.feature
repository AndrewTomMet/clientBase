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
    Then I should be on "/admin/dashboard"

  Scenario: Fail validation Date- add new client - Date
    Given I am on "/login"
    When the response status code should be 200
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/"
    Given I am on "/client_add"
    When I fill in "client_form_firstname" with "TestUserFirstName"
    And I fill in "client_form_surname" with "TestAdminSurName"
    And I fill in "client_form_birthday_day" with "15"
    And I fill in "client_form_birthday_month" with "13"
    And I fill in "client_form_birthday_year" with "2001"
    And I press "client_form_addcontact"
    Then I should be on "/client_add"

  Scenario: Pass add new client
    Given I am on "/login"
    When the response status code should be 200
    When I fill in "_username" with "sysadmin"
    And I fill in "_password" with "sysadmin"
    And I press "_submit"
    Then I should be on "/"
    Given I am on "/client_add"
    When I fill in "client_form_firstname" with "TestUserFirstName"
    And I fill in "client_form_surname" with "TestAdminSurName"
    And I fill in "client_form_birthday_day" with "15"
    And I fill in "client_form_birthday_month" with "12"
    And I fill in "client_form_birthday_year" with "2001"
    And I select "1" from "client_form_categories"
    And I select "1" from "client_form_newtypecontact"
    And I fill in "client_form_newmeancontact" with "newcontact"
    And I press "client_form_addcontact"
    Then I should be on "client_show/2"
