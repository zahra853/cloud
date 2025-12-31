<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midtrans Webhook Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Midtrans Webhook Configuration</h1>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-blue-800 mb-2">Notification URL</h2>
            <div class="bg-white border rounded p-3 font-mono text-sm">
                {{ route('payment.notification') }}
            </div>
            <p class="text-blue-600 text-sm mt-2">
                Configure this URL in your Midtrans dashboard under Settings → Configuration → Notification URL
            </p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-yellow-800 mb-2">Configuration Steps</h2>
            <ol class="list-decimal list-inside text-yellow-700 space-y-1">
                <li>Login to your Midtrans dashboard</li>
                <li>Go to Settings → Configuration</li>
                <li>Set the Notification URL to the URL above</li>
                <li>Make sure your server key is configured in .env file</li>
                <li>Test the webhook with a sample transaction</li>
            </ol>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h2 class="text-lg font-semibold text-green-800 mb-2">Environment Variables</h2>
            <div class="text-green-700 text-sm space-y-1">
                <p><strong>MIDTRANS_SERVER_KEY:</strong> {{ config('midtrans.server_key') ? 'Configured ✓' : 'Not configured ✗' }}</p>
                <p><strong>MIDTRANS_CLIENT_KEY:</strong> {{ config('midtrans.client_key') ? 'Configured ✓' : 'Not configured ✗' }}</p>
                <p><strong>MIDTRANS_IS_PRODUCTION:</strong> {{ config('midtrans.is_production') ? 'Production' : 'Sandbox' }}</p>
            </div>
        </div>
    </div>
</body>
</html>