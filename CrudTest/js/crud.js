// Función para obtener y mostrar los productos
function loadProducts() {
    fetch('crud.php?action=read').catch(error => console.error('Error en fetch:', error))
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const tableBody = document.getElementById('productTableBody');
            tableBody.innerHTML = ''; // Limpiar la tabla
            data.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.price}</td>
                    <td>${product.stock}</td>
                    <td>
                        <button onclick="updateProduct(${product.id})">Actualizar</button>
                        <button onclick="deleteProduct(${product.id})">Eliminar</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }).catch(error => console.error('Error al cargar usuarios:', error));
}

// Función para agregar un product
document.getElementById('productForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const product = document.getElementById('product').value;
    const price = document.getElementById('price').value;
    const stock = document.getElementById('stock').value;

    fetch('crud.php?action=create', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product, price, stock })
    }).then(() => {
        loadUsers(); // Recargar la lista de productos
        document.getElementById('productForm').reset(); // Limpiar formulario
    });
});

// Función para eliminar un procductp
function deleteProduct(id) {
    fetch(`crud.php?action=delete&id=${id}`)
        .then(() => loadProducts()); // Recargar la lista de productos
}


// Función para actualizar un producto
function updateProduct(id) {
    const product = prompt("Ingrese el nuevo nombre del producto:");
    const price = prompt("Ingrese el nuevo precio:");
    const stock = prompt("Ingrese el nuevo stock:");

    if (product && price && stock) {
        fetch(`crud.php?action=update&id=${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_name: product, price: price, stock: stock })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            loadProducts(); // Recargar la lista de productos después de la actualización
        })
        .catch(error => console.error('Error al actualizar producto:', error));
    }
}


// Cargar los productos al cargar la página
loadProducts();
