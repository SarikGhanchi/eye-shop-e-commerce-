document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;
            
            // You can use fetch API to add to cart without page reload
            fetch(`cart.php?action=add&id=${productId}`)
                .then(response => response.text())
                .then(data => {
                    // Update cart count in header
                    const cartBadge = document.querySelector('.badge');
                    cartBadge.textContent = parseInt(cartBadge.textContent) + 1;

                    // Show a notification
                    const notification = document.createElement('div');
                    notification.className = 'alert alert-success position-fixed bottom-0 end-0 m-3';
                    notification.textContent = 'Product added to cart!';
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Cart page functionality
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const removeButtons = document.querySelectorAll('.remove-from-cart');

    quantityInputs.forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.dataset.productId;
            const newQuantity = this.value;
            updateCartItem(productId, newQuantity, 'update_quantity');
        });
    });

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;
            updateCartItem(productId, 0, 'remove');
        });
    });

    function updateCartItem(productId, quantity, action) {
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${action}&id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Reload the page to reflect changes or update DOM dynamically
                window.location.reload();
            } else {
                console.error('Error updating cart:', data);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});