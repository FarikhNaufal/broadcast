
const authEndpoint = 'http://127.0.0.1:8000/broadcasting/auth';
const clientID = '66e767f7-4f4a-4da6-a916-4dd601338e89'; // Ganti dengan ID klien Anda yang sebenarnya
const psID = '166625398.9927560'; // Ganti dengan ID soket Anda yang sebenarnya
const csrfToken = 'jn8ALynwO0AHTVGRQXEPMHSFi17asEeMrgfdtHyo'; // Ganti dengan token CSRF Anda yang sebenarnya

export async function getPusherAuthToken() {
    const response = await fetch(authEndpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken,
        },
        body: JSON.stringify({
            socket_id: psID,
            channel_name: "private-" + clientID,
        }),
    });
    const data = await response.json();

    // Assuming you want to log the token for verification
    console.log(`Auth Token: ${data.auth}`);

    // Save the token to a file or global variable accessible by your test scenario

    return data.auth; // Return the auth token
}
