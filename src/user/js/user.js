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



    let applyForm = document.getElementById('job-application-form');

    applyForm.addEventListener('submit', (e) => { e.preventDefault();

    reset_messages();

    let data = {
      name: applyForm.querySelector('[name="name"]').value,
      email: applyForm.querySelector('[name="email"]').value,
      country: applyForm.querySelector('[name="country"]').value,
      coverletter: applyForm.querySelector('[name="coverletter"]').value,
      resume: applyForm.querySelector('[name="custom_file"]').value,
    }

    if (! data.name) {
      applyForm.querySelector('[data-error="invalidName"]').classList.add('show');
      return;
    }

    if (! validateEmail(data.email)) {
      applyForm.querySelector('[data-error="invalidEmail"]').classList.add('show');
      return;
    }

    if (! data.country) {
      applyForm.querySelector('[data-error="invalidCountry"]').classList.add('show');
      return;
    }

    if (! data.coverletter) {
      applyForm.querySelector('[data-error="invalidCoverletter"]').classList.add('show');
      return;
    }

    if(! data.resume) {
      applyForm.querySelector('[data-error="invalidResume"]').classList.add('show');
      return;
    }

    let url = applyForm.dataset.url;

    let params = new URLSearchParams(new FormData(applyForm));

    applyForm.querySelector('.js-form-submission').classList.add('show');

    fetch(url, {
      method: "POST",
      body: params,

    }).then(res => res.json())
      .catch(error => {
        reset_messages();
        applyForm.querySelector('.js-form-error').classList.add('show');
      })
      .then(response => {
        reset_messages();

        if (response === 0 || response.status === 'error') {
          applyForm.querySelector('.js-form-error').classList.add('show');
          return;
        }
 
        applyForm.querySelector('.js-form-success').classList.add('show');
        applyForm.reset();

      })

    });
  });


  function reset_messages() {
    document.querySelectorAll('.field-msg').forEach(field => field.classList.remove('show'));
  }

  function validateEmail(email) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }
  

  
   