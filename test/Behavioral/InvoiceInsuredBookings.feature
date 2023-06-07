Feature:
  As a user
  I want to get a list of all insured bookings
  so I can invoice them

  Scenario:
    Given An insured booking
      | reference | checkIn    | checkOut   | people | status     |
      | 123456    | 2023-06-08 | 2023-06-11 | 2      | Insured    |
      | 654321    | 2023-07-08 | 2023-07-11 | 1      | Insured    |
      | 872634    | 2023-08-08 | 2023-08-11 | 4      | NotInsured |
      | 234652    | 2023-09-08 | 2023-09-11 | 3      | Insured    |
    When Someone ask for them
    Then List all insured bookings with its premium amount