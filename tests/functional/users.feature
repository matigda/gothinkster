Feature: Testing user endpoints

  Scenario: User authentication
    Given user from "registration.json" exists
    When I send "POST" request on "/api/users/login" with data from "authentication.json"
    Then I get "200" http status
    And response body is same as in "user.json"

  Scenario: User registration
    When I send "POST" request on "/api/users" with data from "registration.json"
    Then I get "201" http status
    And user is added to database
    And response body is same as in "user.json"

  Scenario: Getting authenticated user
    Given user from "registration.json" exists
    When I send "GET" request on "/api/user" authenticated as "jake@jake.jake"
    Then I get "200" http status
    And response body is same as in "user.json"

  Scenario: Updating user
    Given user from "registration.json" exists

  Scenario: Getting user profile
    Given user from "registration.json" exists
    And user from "second_user.json" exists
    When I send "GET" request on "/api/profiles/jake" authenticated as "math@math.meth"
    Then I get "200" http status
    And response body is same as in "profile.json"

  Scenario: Following user
    Given user from "registration.json" exists
    And user from "second_user.json" exists
    When I send "POST" request on "/api/profiles/jake/follow" authenticated as "math@math.meth"
    Then I get "200" http status
    And response body is same as in "profile_followed.json"

  Scenario: Unfollowing user
    Given user from "registration.json" exists
    And user from "second_user.json" exists
    When I send "POST" request on "/api/profiles/jake/follow" authenticated as "math@math.meth"
    When I send "DELETE" request on "/api/profiles/jake/follow" authenticated as "math@math.meth"
    Then I get "200" http status
    And response body is same as in "profile.json"
