<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Currency Conversion</title>
</head>
<body>
<h1>Test Currency Conversion</h1>
<form id="currency-conversion-form">
    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" required>
    <br><br>
    <label for="from">From Currency:</label>
    <input type="text" id="from" name="from" required>
    <br><br>
    <label for="to">To Currency:</label>
    <input type="text" id="to" name="to" required>
    <br><br>
    <button type="submit">Convert</button>
</form>

<h2>Converted Amount: <span id="converted-amount"></span></h2>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('currency-conversion-form');
        const convertedAmountSpan = document.getElementById('converted-amount');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const amount = document.getElementById('amount').value;
            const fromCurrency = document.getElementById('from').value;
            const toCurrency = document.getElementById('to').value;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/currency/convert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    amount: amount,
                    from: fromCurrency,
                    to: toCurrency
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.converted_amount) {
                        convertedAmountSpan.textContent = data.converted_amount;
                    } else {
                        convertedAmountSpan.textContent = 'Error converting currency';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    convertedAmountSpan.textContent = 'Error converting currency';
                });
        });
    });
</script>
</body>
</html>
