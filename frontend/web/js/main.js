var openModalLinks = document.getElementsByClassName("open-modal");
var closeModalLinks = document.getElementsByClassName("form-modal-close");
// var overlay = document.getElementsByClassName("overlay")[0];

for (var i = 0; i < openModalLinks.length; i++) {
  var modalLink = openModalLinks[i];

  modalLink.addEventListener("click", function (event) {
    event.preventDefault();
    var modalId = event.currentTarget.getAttribute("data-for");
    var modal = document.getElementById(modalId);

    // NOTE: fix styles
    modal.setAttribute("style", "display: block; height: 400px;");

    // NOTE: fix it
    var overlay = document.getElementsByClassName("overlay")[0];
    overlay.setAttribute("style", "display: block");
  });
}

function closeModal(event) {
  var modal = event.currentTarget.parentElement;

  // NOTE: fix it
  var overlay = document.getElementsByClassName("overlay")[0];

  modal.removeAttribute("style");
  overlay.removeAttribute("style");
}

for (var j = 0; j < closeModalLinks.length; j++) {
  var closeModalLink = closeModalLinks[j];

  closeModalLink.addEventListener("click", closeModal)
}

// NOTE: breaks the code
// document.getElementById('close-modal').addEventListener("click", closeModal);

var starRating = document.getElementsByClassName("completion-form-star");

if (starRating.length) {
  starRating = starRating[0];

  starRating.addEventListener("click", function(event) {
    var stars = event.currentTarget.childNodes;
    var rating = 0;

    for (var i = 0; i < stars.length; i++) {
      var element = stars[i];

      if (element.nodeName === "SPAN") {
        element.className = "";
        rating++;
      }

      if (element === event.target) {
        break;
      }
    }

    var inputField = document.getElementById("rating");
    inputField.value = rating;
  });
}
