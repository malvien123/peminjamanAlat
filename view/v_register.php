<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar</title>
  <link rel="stylesheet" href="../asset/style_register.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f4;">

  <div class="container">
    <h2>Registrasi</h2>
    <form action="../controller/c_user.php?aksi=tambah" method="post"> 
      <!-- <label for="id_user">id_user:</label> -->
      
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="role">Role:</label>
      <input type="text" id="role" name="role" value="peminjam" readonly>

      <button type="submit" value="Daftar" name="tambah">Daftar </button>
      
    </form>
  </div>

</body>
</html>
