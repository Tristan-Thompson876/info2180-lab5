document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.getElementById('lookup');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    lookupButton.addEventListener('click', () => {
        const country = countryInput.value.trim();
        if (country) {
            fetch(`world.php?country=${encodeURIComponent(country)}`)
                .then(response => response.text())
                .then(data => {
                    resultDiv.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultDiv.innerHTML = '<p>There was an error processing your request.</p>';
                });
        } else {
            resultDiv.innerHTML = '<p>Please enter a country name.</p>';
        }
    });
});