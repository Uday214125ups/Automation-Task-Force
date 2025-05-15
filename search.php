<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Product Display</title>
  <style>
    .back-btn {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  margin-bottom: 1.5rem;
  transition: background-color 0.3s ease;
}

.back-btn:hover {
  background-color: #2980b9;
}

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1300px;
      margin: auto;
      padding: 2.5rem;
    }

    h1 {
      text-align: center;
      margin-bottom: 2rem;
      color: #333;
    }

    .product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  opacity: 1;
  transition: opacity 0.5s ease;
}
.product-grid.fade-out {
  opacity: 0;
}

    .product-card {
      background: #fff;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s;
      min-height: 360px;
      cursor: pointer;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      max-width: 100%;
      height: 200px;
      object-fit: contain;
      margin-bottom: 1rem;
    }

    .product-title {
      font-size: 1rem;
      font-weight: 600;
      margin: 0.5rem 0;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      min-height: 3em;
    }

    .product-price {
      color: #27ae60;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 2rem;
      gap: 10px;
    }

    .pagination button {
  background: #ffffff;
  border: 1px solid #dcdcdc;
  padding: 0.6rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  color: #333;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease, box-shadow 0.5s ease;
}

    .pagination button:hover {
      background: #3498db;
      color: #fff;
      border-color: #3498db;
    }

    .pagination button.active {
      background-color: #3498db;
      color: #fff;
      border-color: #3498db;
      box-shadow: 0 3px 8px rgba(52, 152, 219, 0.3);
    }

    .pagination button:disabled {
      background: #eee;
      color: #aaa;
      cursor: not-allowed;
      box-shadow: none;
    }
/* Add this to your existing style */
#productModal .modal-content {
  transform: scale(0.8);
  opacity: 0;
  transition: transform 0.6s ease, opacity 0.6s ease;
}

#productModal.show .modal-content {
  transform: scale(1);
  opacity: 1;
}

    /* Modal styles */
    #productModal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    #productModal .modal-content {
      background: #fff;
      padding: 2rem;
      max-width: 600px;
      width: 90%;
      border-radius: 10px;
      position: relative;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    #productModal img {
      width: 100%;
      max-height: 300px;
      object-fit: contain;
      margin-bottom: 1rem;
    }

    #productModal span.close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 1.5rem;
      cursor: pointer;
    }

    #modalTitle {
      margin: 0.5rem 0;
    }

    #modalPrice {
      font-weight: bold;
      color: #27ae60;
    }

    #modalCategory {
      font-style: italic;
      color: gray;
    }
  </style>
</head>
<body>
  <div class="container">
    <button onclick="history.back()" class="back-btn">← Go Back</button>
    <h1>Your Products</h1>
    <div class="product-grid" id="product-grid"></div>
    <div class="pagination" id="pagination"></div>
  </div>

  <!-- Product Detail Modal -->
  <div id="productModal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <img id="modalImage" src="" alt="">
      <h2 id="modalTitle"></h2>
      <p id="modalPrice"></p>
      <p id="modalDescription"></p>
      <p id="modalCategory"></p>
    </div>
  </div>

  <script>
    const productsPerPage = 5;
    let products = [];
    let currentPage = 1;

    async function fetchProducts() {
      try {
        const response = await fetch('https://fakestoreapi.com/products');
        products = await response.json();
        renderProducts();
        renderPagination();
      } catch (error) {
        console.error("Error fetching products:", error);
        document.getElementById('product-grid').innerHTML = "<p>Failed to load products.</p>";
      }
    }

    function renderProducts() {
  const grid = document.getElementById('product-grid');
  
  // Add fade-out class to start fading out old content
  grid.classList.add('fade-out');

  setTimeout(() => {
    const start = (currentPage - 1) * productsPerPage;
    const end = start + productsPerPage;
    const visibleProducts = products.slice(start, end);

    grid.innerHTML = ''; // Clear old content

    visibleProducts.forEach(product => {
      const card = document.createElement('div');
      card.className = 'product-card';

      const img = document.createElement('img');
      img.src = product.image;
      img.alt = product.title;

      const title = document.createElement('div');
      title.className = 'product-title';
      title.textContent = product.title;

      const price = document.createElement('div');
      price.className = 'product-price';
      price.textContent = `$${product.price}`;

      card.appendChild(img);
      card.appendChild(title);
      card.appendChild(price);

      // Attach click listener to open modal with full product info
      card.addEventListener('click', () => {
        showModal(product);
      });

      grid.appendChild(card);
    });

    // Remove fade-out class to trigger fade-in transition
    grid.classList.remove('fade-out');
  }, 300); // timeout shorter than CSS transition duration
}


    function renderPagination() {
      const totalPages = Math.ceil(products.length / productsPerPage);
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';

      const prev = document.createElement('button');
      prev.textContent = "Previous";
      prev.disabled = currentPage === 1;
      prev.onclick = () => {
        currentPage--;
        renderProducts();
        renderPagination();
      };
      pagination.appendChild(prev);

      for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.textContent = i;
        if (i === currentPage) pageBtn.classList.add('active');
        pageBtn.onclick = () => {
          currentPage = i;
          renderProducts();
          renderPagination();
        };
        pagination.appendChild(pageBtn);
      }

      const next = document.createElement('button');
      next.textContent = "Next";
      next.disabled = currentPage === totalPages;
      next.onclick = () => {
        currentPage++;
        renderProducts();
        renderPagination();
      };
      pagination.appendChild(next);
    }

function showModal(product) {
  const modal = document.getElementById("productModal");

  // Set display flex first, then trigger transition
  modal.style.display = "flex";

  // Allow next repaint, then add show class to animate
  requestAnimationFrame(() => {
    modal.classList.add("show");
  });

  document.getElementById("modalImage").src = product.image;
  document.getElementById("modalTitle").textContent = product.title;
  document.getElementById("modalPrice").textContent = `$${product.price}`;
  document.getElementById("modalDescription").textContent = product.description;
  document.getElementById("modalCategory").textContent = `Category: ${product.category}`;
}

function closeModal() {
  const modal = document.getElementById("productModal");
  modal.classList.remove("show");

  // Wait for the CSS transition to end before hiding
  setTimeout(() => {
    modal.style.display = "none";
  }, 300); // This must match your CSS transition duration
}

document.getElementById('productModal').addEventListener('click', function(event) {
  if (event.target === this) {
    closeModal();
  }
});


    fetchProducts();
  </script>
</body>
</html>
