Feature:
  As a user
  I want to do several actions to my bookings
  so I can confirm, insure and cancel the booking

  Scenario Outline:
    Given The followings bookings
      | reference | checkIn    | checkOut   | people | status     |
      | 456234    | 2023-06-08 | 2023-06-11 | 1      | NotInsured |
      | 983245    | 2023-07-08 | 2023-07-11 | 3      | NotInsured |
      | 327456    | 2023-08-08 | 2023-08-11 | 1      | NotInsured |
      | 509877    | 2023-09-08 | 2023-09-11 | 5      | NotInsured |
    And The 'Content-Type' request header is 'application/json'
    And The 'Cookie' request header is 'XDEBUG_SESSION=PHPSTORM'
    And The request body is '<payload>'
    When I request '/actions' using HTTP 'POST'
    Then The response code is '<status>'
    And The status of the booking is '<booking_status>'
    And The premiumAmount is '<premium_amount>'
    And I delete the bookings created

    Examples:
      | payload | status | booking_status | premium_amount |
      | {}      | 422    | null           | null           |
      | {"reference": "jkhdsdf","action":"confirmation","check_in":"2023-06-08","check_out":"2023-06-08","people":2} | 404    | null           | null            |
      | {"reference": "456234","action":"confirmation","check_in":"asdasd","check_out":"2023-06-08","people":0}      | 422    | null           | null            |
      | {"reference": "456234","action":"confirmation","check_in":"2023-06-08","check_out":"asdad","people":2}       | 422    | null           | null            |
      | {"reference": "456234","action":"confirmation","check_in":"2023-06-08","check_out":"2023-06-08","people":0}  | 422    | null           | null            |
      | {"reference": "456234","action":"confirmation","check_in":"2023-06-08","check_out":"2023-06-08","people":1}  | 422    | null           | null            |
      | {"reference": "983245","action":"confirmation","check_in":"2023-06-08","check_out":"2023-06-11","people":1}  | 200    | Insured        | 0.36            |
      | {"reference": "327456","action":"confirmation","check_in":"2023-06-08","check_out":"2023-07-08","people":3}  | 200    | Insured        | 2.76            |
      | {"reference": "509877","action":"confirmation","check_in":"2023-06-08","check_out":"2023-06-18","people":4}  | 200    | Insured        | 1.28            |
      | {"reference": "509877","action":"modification","check_in":"2023-10-08","check_out":"2023-10-18","people":2}  | 200    | Insured        | 1.04            |
