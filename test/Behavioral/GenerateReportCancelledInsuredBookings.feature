Feature:
  As a user
  I want to generate a report of cancelled insured bookings
  so I can manage the cancellations

  Scenario:
    Given Some cancelled insured bookings
    When Someone ask for them
    Then List them all