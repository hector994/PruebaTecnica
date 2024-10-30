var selectedProducts = [];

// Función para buscar productos
document.getElementById('searchButton').addEventListener('click', function () {
    const searchValue = document.getElementById('search').value;
    fetch(`crud.php?action=read&search=${searchValue}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('productsTableBody');
            tableBody.innerHTML = ''; // Limpiar tabla
            data.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.price}</td>
                    <td>${product.stock}</td>
                    <td>
                        <button onclick="addToSelected(${product.id}, '${product.product_name}', ${product.price}, ${product.stock})">Agregar</button>
                    </td>
                    <td>
                        <input type="number" id="quantityInput" placeholder="Cantidad">
                        <button id="addProductButton">Agregar a Venta</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error al buscar productos:', error));
});

// Mostrar el campo de cantidad cuando se selecciona un producto
function addToSelected(id, name, price, stock) {
    console.log(`Función llamada con ID: ${id}, Nombre: ${name}, Precio: ${price}, Stock: ${stock}`);
    
    // Mostrar el input de cantidad y el botón
    const quantityInput = document.getElementById('quantityInput');
    const addProductButton = document.getElementById('addProductButton');
    
    quantityInput.style.display = 'inline';
    addProductButton.style.display = 'inline';
    
    // Configurar el evento para agregar el producto con la cantidad
    addProductButton.onclick = function() {
        const quantity = parseInt(quantityInput.value);
        if (quantity && !isNaN(quantity) && quantity > 0) {
            if (quantity > stock) {
                alert("No hay suficiente stock disponible.");
                return;
            }
            
            const subtotal = price * quantity;
            selectedProducts.push({ id, name, price, quantity, subtotal });
            renderSelectedProducts();
            
            // Ocultar el input de cantidad y el botón después de agregar
            quantityInput.style.display = 'none';
            addProductButton.style.display = 'none';
            quantityInput.value = ''; // Limpiar el valor
        } else {
            alert("Cantidad inválida.");
        }
    };
}


// Función para renderizar la tabla de productos seleccionados
function renderSelectedProducts() {
    const tableBody = document.getElementById('selectedProductsTableBody');
    tableBody.innerHTML = ''; // Limpiar tabla
    selectedProducts.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>${product.quantity}</td>
            <td>${product.subtotal}</td>
            <td>
                <button onclick="removeProduct(${product.id})">Eliminar</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Función para eliminar un producto de la lista de seleccionados
function removeProduct(id) {
    selectedProducts = selectedProducts.filter(product => product.id !== id);
    renderSelectedProducts();
}

// Función para realizar la compra
document.getElementById('completeSaleButton').addEventListener('click', function () {
    if (selectedProducts.length === 0) {
        alert("No hay productos seleccionados para realizar la compra.");
        console.log("");
        
        return;
    }
    
    const invoiceData = {
        products: selectedProducts,
        total: selectedProducts.reduce((acc, product) => acc + product.subtotal, 0)
    };

    fetch('invoice.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(invoiceData)
    })
    .then(response => response.text()) // Cambiar a .text() temporalmente
    .then(text => {
        console.log("Respuesta del servidor:", text); // Verificar el contenido exacto de la respuesta
        const data = JSON.parse(text); // Convertir a JSON después de verificar
        if (data.status === 'success') {
            alert("Compra realizada con éxito!");
            selectedProducts = []; // Limpiar productos seleccionados
            renderSelectedProducts();
        } else {
            alert("Error al realizar la compra: " + data.message);
        }
    })
    .catch(error => console.error('Error al realizar la compra:', error));
    
});
