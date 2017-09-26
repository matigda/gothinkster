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
#    Given some user is authenticated
    When I send "GET" request on "/api/user"
    Then I get "200" http status
    And response body is same as in "user.json"

  Scenario: Updating user
#    Given some user is authenticated
#    @TODO

  Scenario: Getting user profile
    When I send "GET" request on "/api/profiles/jake"
    Then I get "200" http status
    And response body is same as in "profile.json"

  Scenario: Following user
#    Given some user is authenticated
    When I send "POST" request on "/api/profiles/jake/follow"
    Then I get "200" http status
    And response body is same as in "profile.json"

  Scenario: Unfollowing user
#    Given some user is authenticated
    When I send "DELETE" request on "/api/profiles/jake/follow"
    Then I get "200" http status
    And response body is same as in "profile.json"
