document.addEventListener("DOMContentLoaded", function() {
    // Get the modal
    const modal = document.getElementById("myModal");
  
    // Get the button that opens the modal
    const openModalBtn = document.getElementById("openModalBtn");
  
    // Get the <span> element that closes the modal
    const closeBtn = modal.querySelector(".close");
  
    // Function to open the modal
    const openModal = () => {
      modal.style.display = "block";
    };
  
    // Function to close the modal
    const closeModal = () => {
      modal.style.display = "none";
    };
  
    // When the user clicks the button, open the modal
    openModalBtn.addEventListener("click", openModal);
  
    // When the user clicks anywhere outside of the modal, close it
    window.addEventListener("click", (event) => {
      if (event.target === modal) {
        closeModal();
      }
    });
  
    // When the user clicks on the close button (X), close the modal
    closeBtn.addEventListener("click", closeModal);
  });
  
  