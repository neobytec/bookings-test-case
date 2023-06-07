Feature:
  As a user
  I want insure a confirmed booking
  So I can cancel the booking if I need it

  Scenario:
    Given A booking
    When A confirmation arrives
    Then Insure the booking