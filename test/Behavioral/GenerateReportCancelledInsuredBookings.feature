Feature:
  As a user
  I want to generate a report of cancelled insured bookings
  so I can manage the cancellations

  Scenario:
    Given Some cancelled insured bookings
      | reference | checkIn    | checkOut   | people | status     |
      | 123456    | 2023-06-08 | 2023-06-11 | 2      | Insured    |
      | 654321    | 2023-07-08 | 2023-07-11 | 1      | Cancelled  |
      | 872634    | 2023-08-08 | 2023-08-11 | 4      | NotInsured |
      | 234652    | 2023-09-08 | 2023-09-11 | 3      | Cancelled  |
    When Someone ask for them
    Then List them all