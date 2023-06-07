document.addEventListener('DOMContentLoaded', function() {
    const userTypeSelect = document.getElementById('userType');
    const patientFields = document.getElementById('patientFields');
    const practitionerFields = document.getElementById('practitionerFields');

    userTypeSelect.addEventListener('change', function() {
    var patientInputs = patientFields.querySelectorAll('input, textarea');
    var practitionerInputs = practitionerFields.querySelectorAll('input, textarea');
    commonFields.style.display = 'block';
    if (this.value == 'patient') {
        patientFields.style.display = 'block';
        practitionerFields.style.display = 'none';

        patientInputs.forEach(function(input) {
            input.required = true;
        });

        practitionerInputs.forEach(function(input) {
            input.required = false;
        });

    } else {
        patientFields.style.display = 'none';
        practitionerFields.style.display = 'block';

        patientInputs.forEach(function(input) {
            input.required = false;
        });

        practitionerInputs.forEach(function(input) {
            input.required = true;
        });
    }
});
});