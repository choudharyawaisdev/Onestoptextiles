// Simple Shopping Cart Logic
let count = 0;
const cartBadge = document.getElementById('cart-count');
const addButtons = document.querySelectorAll('.add-to-cart');

addButtons.forEach(button => {
    button.addEventListener('click', function() {
        count++;
        cartBadge.innerText = count;
        
        // Animation effect
        this.innerText = "Added to Cart!";
        this.style.background = "#c5a992";
        
        setTimeout(() => {
            this.innerText = "Add to Cart";
            this.style.background = "";
        }, 1500);
    });
});