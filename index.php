<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Home - Professional Page</title>
  <style>
    /* Reset & basics */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html, body {
      height: 100%;
      width: 100%;
    }

    body {
      background-color: rgb(114, 255, 189);
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.3));
      z-index: 0;
    }

    .content {
      position: relative;
      z-index: 1;
      text-align: center;
      max-width: 450px;
      padding: 3rem;
      background: #ffffffdd;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      animation: fadeIn 0.5s ease-in-out;
    }

    .content h1 {
      font-size: 2.5rem;
      margin-bottom: 2rem;
      font-weight: 700;
      color: #333;
    }

    .btn-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    button {
      background-color: #0066cc;
      border: none;
      padding: 0.75rem 2rem;
      border-radius: 8px;
      font-size: 1rem;
      color: white;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0, 102, 204, 0.2);
      transition: all 0.3s ease;
      min-width: 150px;
    }

    button:hover {
      background-color: #004c99;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 76, 153, 0.3);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.98);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @media(max-width: 500px) {
      .content {
        max-width: 90vw;
        padding: 2rem;
      }

      .btn-group {
        flex-direction: column;
        gap: 15px;
      }

      button {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="content">
    <h1>WELCOME</h1>
    <div class="btn-group">
      <button onclick="location.href='search.php'">View Your Products</button>
      <button onclick="location.href='lists.php'">Login</button>
    </div>
  </div>
</body>
</html>


