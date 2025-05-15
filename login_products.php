<?php
session_start(); 
// products.php
// Database connection
$host = "localhost";
$user = "root";
$password = ""; // change as needed
$db = "dog_images_app";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$result = $conn->query("SELECT * FROM ".$_SESSION['login']."_products ORDER BY id DESC");

$products = [];
while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Product Display</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <style>
   .top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}
.confirm {
  background: #27ae60;
  color: #fff;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.confirm:hover {
  background-color:rgb(26, 120, 65);
}

.back-btn {
  background: #3498db;
  color: #fff;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.back-btn:hover {
  background-color: #2980b9;
}

.edit {
  background: #3498db;
  color: #fff;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.edit:hover {
  background-color: #2980b9;
}

.profile {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: #333;
  font-size: 1rem;
}

.profile i {
  font-size: 1.8rem;
  color: #555;
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
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
  <div class="container">
    <div class="top-bar">
      <button onclick="history.back()" class="back-btn">← LogOut</button>
      <button class="back-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
        Add Product
    </button>
    <button class="back-btn" data-bs-toggle="modal" data-bs-target="#filterModal">
  Filter
</button>
      <div class="profile">
        <i class="fas fa-user-circle"></i>
        <span><?php echo $_SESSION['login']; ?> </span>
      </div>
    </div>
    <h1>Your Products</h1>
    <div class="product-grid" id="product-grid"></div>
    <div class="pagination" id="pagination"></div>
  </div>





  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3" style="display:none">
          <label for="sortCategory" class="form-label">Sort by Category</label>
          <select class="form-select" id="sortCategory">
            <option value="">-- None --</option>
            <option value="asc">A to Z</option>
            <option value="desc">Z to A</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="sortPrice" class="form-label">Sort by Price</label>
          <select class="form-select" id="sortPrice">
            <option value="">-- None --</option>
            <option value="low">Low to High</option>
            <option value="high">High to Low</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="applyFilter()" data-bs-dismiss="modal">Apply</button>
      </div>
    </div>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="add_product.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control" name="product_name" required>
            </div><div class="mb-3">
              <label for="product_image_link" class="form-label">Product Image Link</label>
              <input type="text" class="form-control" name="product_image_link" required>
            </div>
            <div class="mb-3">
              <label for="product_price" class="form-label">Price</label>
              <input type="number" class="form-control" name="product_price" required>
            </div>
            <div class="mb-3">
              <label for="cataegory" class="form-label">Cataegory</label>
              <input type="text" class="form-control" name="cataegory" required>
            </div>
            <div class="mb-3">
              <label for="product_description" class="form-label">Description</label>
              <textarea class="form-control" name="product_description" rows="3"></textarea>
            </div>
            <!-- Add other fields as needed -->
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add Product</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

  <!-- Modal -->
  <div id="productModal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="" alt="">
    <input type="file" id="imageInput" style="display: none;">
    <h2 id="modalTitle" contenteditable="false"></h2>
    <p id="modalPrice" contenteditable="false"></p>
    <p id="modalDescription" contenteditable="false"></p>
    <p id="modalCategory" contenteditable="false"></p>

    <div style="margin-top: 1rem;">
      <button id="editBtn" onclick="enableEdit()" class="edit">Edit</button>
      <button id="confirmBtn" style="display:none;" class="confirm" onclick="confirmEdit()">Confirm</button>
      <button id="deleteBtn" class="confirm" style="background: #e74c3c;" onclick="deleteProduct()">Delete</button>

     
    </div>
  </div>
</div>


  <script>
   
function applyFilter() {
  const catSort = document.getElementById("sortCategory").value;
  const priceSort = document.getElementById("sortPrice").value;

  let filtered = [...products];

  if (catSort === "asc") {
    filtered.sort((a, b) => a.category.localeCompare(b.category));
  } else if (catSort === "desc") {
    filtered.sort((a, b) => b.category.localeCompare(a.category));
  }

  if (priceSort === "low") {
    filtered.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
  } else if (priceSort === "high") {
    filtered.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
  }

  productsFiltered = filtered;
  currentPage = 1;
  renderProducts(productsFiltered);
  renderPagination(productsFiltered);
}


    const products = <?php echo json_encode($products); ?>;
    const productsPerPage = 5;
    let currentPage = 1;

  function renderProducts(list = products) {
  const grid = document.getElementById('product-grid');
  grid.classList.add('fade-out');

  setTimeout(() => {
    const start = (currentPage - 1) * productsPerPage;
    const end = start + productsPerPage;
    const visibleProducts = list.slice(start, end);

    grid.innerHTML = '';
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

      card.addEventListener('click', () => showModal(product));
      grid.appendChild(card);
    });

    grid.classList.remove('fade-out');
  }, 300);
}

function renderPagination(list = products) {
  const totalPages = Math.ceil(list.length / productsPerPage);
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  const prev = document.createElement('button');
  prev.textContent = "Previous";
  prev.disabled = currentPage === 1;
  prev.onclick = () => {
    currentPage--;
    renderProducts(list);
    renderPagination(list);
  };
  pagination.appendChild(prev);

  for (let i = 1; i <= totalPages; i++) {
    const pageBtn = document.createElement('button');
    pageBtn.textContent = i;
    if (i === currentPage) pageBtn.classList.add('active');
    pageBtn.onclick = () => {
      currentPage = i;
      renderProducts(list);
      renderPagination(list);
    };
    pagination.appendChild(pageBtn);
  }

  const next = document.createElement('button');
  next.textContent = "Next";
  next.disabled = currentPage === totalPages;
  next.onclick = () => {
    currentPage++;
    renderProducts(list);
    renderPagination(list);
  };
  pagination.appendChild(next);
}
    let currentProduct = null;

function showModal(product) {
  const modal = document.getElementById("productModal");
  modal.style.display = "flex";
  requestAnimationFrame(() => modal.classList.add("show"));

  currentProduct = { ...product };

  document.getElementById("modalImage").src = product.image;
  document.getElementById("modalTitle").textContent = product.title;
  document.getElementById("modalPrice").textContent = `$${product.price}`;
  document.getElementById("modalDescription").textContent = product.description;
  document.getElementById("modalCategory").textContent = `Category: ${product.category}`;

  // Reset editing state
  disableEdit();
}

function enableEdit() {
  document.getElementById("modalTitle").contentEditable = "true";
  document.getElementById("modalPrice").contentEditable = "true";
  document.getElementById("modalDescription").contentEditable = "true";
  document.getElementById("modalCategory").contentEditable = "true";

  document.getElementById("editBtn").style.display = "none";
  document.getElementById("confirmBtn").style.display = "inline-block";
}

function disableEdit() {
  document.getElementById("modalTitle").contentEditable = "false";
  document.getElementById("modalPrice").contentEditable = "false";
  document.getElementById("modalDescription").contentEditable = "false";
  document.getElementById("modalCategory").contentEditable = "false";

  document.getElementById("editBtn").style.display = "inline-block";
  document.getElementById("confirmBtn").style.display = "none";
}

function confirmEdit() {
  const updatedProduct = {
    id: currentProduct.id,
    title: document.getElementById("modalTitle").textContent.trim(),
    price: parseFloat(document.getElementById("modalPrice").textContent.replace('$','')),
    description: document.getElementById("modalDescription").textContent.trim(),
    category: document.getElementById("modalCategory").textContent.replace("Category: ","").trim()
  };

  fetch('update_product.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(updatedProduct)
  })
  .then(response => response.text())
  .then(data => {
    alert("Product updated successfully.");
    
    // Update product in the array
    const index = products.findIndex(p => p.id === updatedProduct.id);
    if (index !== -1) {
      products[index] = { ...products[index], ...updatedProduct };
    }

    renderProducts();  // Rerender the visible product cards
    disableEdit();
    closeModal();
  })
  .catch(error => {
    console.error('Error updating product:', error);
    alert("Failed to update product.");
  });
}


    function closeModal() {
      const modal = document.getElementById("productModal");
      modal.classList.remove("show");
      setTimeout(() => {
        modal.style.display = "none";
      }, 300);
    }

    document.getElementById('productModal').addEventListener('click', function(event) {
      if (event.target === this) {
        closeModal();
      }
    });

    renderProducts();
    renderPagination();
    function deleteProduct() {
  if (!confirm("Are you sure you want to delete this product?")) return;

  fetch('delete_product.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: currentProduct.id })
  })
  .then(response => response.text())
  .then(data => {
    alert("Product deleted successfully.");

    // Remove from local array
    const index = products.findIndex(p => p.id === currentProduct.id);
    if (index !== -1) {
      products.splice(index, 1);
    }

    renderProducts();
    renderPagination();
    closeModal();
  })
  .catch(error => {
    console.error('Error deleting product:', error);
    alert("Failed to delete product.");
  });
}

  </script>
  <!-- Bootstrap JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
