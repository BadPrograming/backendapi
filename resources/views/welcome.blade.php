<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Layanan Kami - SORE Agency</title>
  <style>
    body { font-family: Arial; background: #fafafa; padding: 40px; }
    .service-card { background: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <h1>Layanan Kami</h1>

  <div id="services"></div>

  <script>
    // Ambil data dari API Laravel
    fetch('http://127.0.0.1:8000/api/services')
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          const container = document.getElementById('services');
          result.data.forEach(service => {
            const card = document.createElement('div');
            card.classList.add('service-card');
            card.innerHTML = `
              <h3>${service.title}</h3>
              <p>${service.description}</p>
            `;
            container.appendChild(card);
          });
        }
      })
      .catch(error => console.error('Error:', error));
  </script>
</body>
</html>
