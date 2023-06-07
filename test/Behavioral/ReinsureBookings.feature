Feature:
  As a user
  I want to modify the booking and reinsure it
  So I can change the booking and keep the insurance

  Scenario:
    Given An insured booking
    When A modification arrives
    Then Reinsure the booking with the newer information