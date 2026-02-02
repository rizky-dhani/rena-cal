# Spec: Status Selection in QR Generation

## MODIFIED Requirements

### Requirement: QR generation status selection
Users MUST be able to specify the calibration result (status) when generating empty QR codes.

#### Scenario: Generating empty QR codes with "Laik Pakai" status
Given I am on the Devices list page
When I click "Generate Empty QR Codes"
And I enter "5" as the number of QR codes
And I select "Laik Pakai" as the result
And I submit the form
Then 5 new device records should be created in the background
And each of these records should have the `result` set to "Laik Pakai"

#### Scenario: Generating empty QR codes with "Tidak Laik Pakai" status
Given I am on the Devices list page
When I click "Generate Empty QR Codes"
And I enter "3" as the number of QR codes
And I select "Tidak Laik Pakai" as the result
And I submit the form
Then 3 new device records should be created in the background
And each of these records should have the `result` set to "Tidak Laik Pakai"
