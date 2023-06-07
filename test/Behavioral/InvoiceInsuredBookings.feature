Feature:
  As a user
  I want to get a list of all insured bookings
  so I can invoice them

  Scenario:
    Given An insured booking
    When Someone ask for them
    Then List all insured bookings with its premium amount