Feature:
  As a user
  I want to do several actions to my bookings
  so I can confirm, insure and cancel the booking

  Scenario:
    Given The followings bookings
      | reference | checkIn    | checkOut   | people | status     |
      | 862375    | 2023-06-08 | 2023-06-11 | 1      | NotInsured |
      | 234525    | 2023-07-08 | 2023-07-11 | 3      | Cancelled  |
      | 345632    | 2023-08-08 | 2023-08-11 | 1      | Insured    |
      | 987656    | 2023-09-08 | 2023-09-11 | 5      | Cancelled  |
      | 786345    | 2023-10-08 | 2023-10-11 | 1      | Cancelled  |
      | 527566    | 2023-11-08 | 2023-11-11 | 2      | Insured    |
      | 672409    | 2023-12-08 | 2023-12-11 | 4      | Cancelled  |
    And The 'Content-Type' request header is 'application/json'
    When I request '/bookings/insured' using HTTP 'GET'
    Then The response code is '200'
    And The number of insured bookings is '2'
    And I delete the bookings created