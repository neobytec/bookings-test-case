Feature:
  As a user
  I want to modify the booking and reinsure it
  So I can change the booking and keep the insurance

  Scenario:
    Given An insured booking
      | reference | checkIn    | checkOut   | people | status     |
      | 123456    | 2023-06-08 | 2023-06-11 | 2      | Insured    |
    When A modification arrives
      | reference | action       | checkIn    | checkOut   | people |
      | 123456    | Modification | 2023-07-08 | 2023-07-11 | 3      |
    Then Reinsure the booking with the newer information