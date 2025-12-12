document.addEventListener('DOMContentLoaded', function() {
  var addToCartForm = document.querySelector('form[action="/cart/add"]');
  if (addToCartForm) {
    addToCartForm.addEventListener('submit', function(event) {
      alert("added to cart")
      console.log(event)
    });
  }
});