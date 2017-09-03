Feature: Testing endpoints

  Scenario: User authentication
    When I use "POST" method on "/api/users/login" with data from "authentication.json"
    Then I get "200" http status
    And response body is same as in "user.json"


  Scenario: Getting authenticated user
#    Given some user is authenticated
    When I use "GET" method on "/api/user"
    Then I get "200" http status
