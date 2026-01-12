<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=g, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="max-width: 480px; margin: 0 auto;">
    <div id="login">
        <h1>Test Sign in</h1>
        <form id="login-form"style="background: #f1f1f1; padding:24px; border-radius: 8px;">
            <input type="text" name="username" id="username" placeholder="username" style="width: 100%"><br><br>
            <input type="password" name="password" id="password" placeholder="password" style="width: 100%"><br><br>
            <button type="submit">Sign in</button>
        </form>
    </div>
    
    <pre style="width: 100%; overflow-x: auto"><code id="result"></code></pre>

    <div id="dashboard" style="display: none;">
        <h1>Dashboard</h1>
        <form id="logout-form" method="post">
            <button type="submit">Log out</button>
        </form>
        <br>
        <div style="display: flex; flex-wrap: wrap; gap: 16px">
            <div style="width: 100px; height: 100px; background: black"></div>
            <div style="width: 100px; height: 100px; background: gray"></div>
            <div style="width: 100px; height: 100px; background: red"></div>
            <div style="width: 100px; height: 100px; background: blue"></div>
            <div style="width: 100px; height: 100px; background: green"></div>
        </div>
    </div>
<script>
    const token = localStorage.getItem('token');
    const formLogout = document.getElementById('logout-form');
    const formLogin = document.getElementById('login-form');

    if (token) {
        document.getElementById('dashboard').style.display = "block";
        document.getElementById('login').style.display = "none";
    } else {
        document.getElementById('dashboard').style.display = "none";
        document.getElementById('login').style.display = "block";
    }
</script>

<script>
    formLogout.addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const token = localStorage.getItem('token');

        if (!token) {
            document.getElementById('result').textContent =
                'Token tidak ditemukan (sudah logout?)';
            return;
        }

        try {
            const response = await fetch('/api/auth/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                // hapus token
                localStorage.removeItem('token');

                document.getElementById('result').textContent =
                    'Logout berhasil:\n' + JSON.stringify(data, null, 2);

                document.getElementById('dashboard').style.display = "none";
                document.getElementById('login').style.display = "block";

                console.log('Logout success');
            } else {
                document.getElementById('result').textContent =
                    'Logout gagal:\n' + JSON.stringify(data, null, 2);
            }

        } catch (error) {
            console.error(error);
            document.getElementById('result').textContent =
                'Terjadi error saat logout';
        }
    });
</script>
<script>
    formLogin.addEventListener('submit', async function (e) {
        e.preventDefault(); // stop reload

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            });

            const jsonData = await response.json();

            document.getElementById('result').textContent =
                JSON.stringify(jsonData, null, 2);

            if (response.ok) {
                console.log('Login success', jsonData);

                document.getElementById('dashboard').style.display = "block";
                document.getElementById('login').style.display = "none";
                // simpan token di local storage
                if (jsonData.data.access_token) {
                    localStorage.setItem('token', jsonData.data.access_token);
                }
            } else {
                console.error('Login failed', jsonData);
            }

        } catch (error) {
            console.error(error);
        }
    });
</script>
</body>
</html>