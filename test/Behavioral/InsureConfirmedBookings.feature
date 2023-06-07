Feature:
  As a user
  I want insure a confirmed booking
  So I can cancel the booking if I need it

  Scenario:
    Given A booking
      | reference | checkIn    | checkOut   | people | status     |
      | 123456    | 2023-06-08 | 2023-06-11 | 2      | NotInsured |
    When A confirmation arrives
      | reference | action       | checkIn    | checkOut   | people |
      | 123456    | Confirmation | 2023-06-08 | 2023-06-11 | 2      |
    Then Insure the booking