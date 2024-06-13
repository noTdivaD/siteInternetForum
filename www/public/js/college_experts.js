document.addEventListener('DOMContentLoaded', function () {
    var faqSearch = document.getElementById('faq-search');
    var faqItems = document.querySelectorAll('.faq-item');
    var noResultsMessage = document.getElementById('no-results-message');
    var editFAQModal = document.getElementById('editFAQModal');
    var addFAQModal = document.getElementById('addFAQModal');
    var editExpertModal = document.getElementById('editExpertModal');
    var addExpertModal = document.getElementById('addExpertModal');
    var closeButtons = document.querySelectorAll('.close');
    var editFAQForm = document.getElementById('editFAQForm');
    var addFAQForm = document.getElementById('addFAQForm');
    var editFAQId = document.getElementById('edit-faq-id');
    var editQuestion = document.getElementById('edit-question');
    var editAnswer = document.getElementById('edit-answer');
    var editExpertForm = document.getElementById('editExpertForm');
    var addExpertForm = document.getElementById('addExpertForm');
    var editExpertId = document.getElementById('edit-expert-id');
    var editTitle = document.getElementById('edit-title');
    var editDescription = document.getElementById('edit-description');
    var editPhone = document.getElementById('edit-phone');
    var editEmail = document.getElementById('edit-email');
    var dropZoneEdit = document.getElementById('drop-zone-edit');
    var dropZoneAdd = document.getElementById('drop-zone-add');
    var deleteImageContainer = document.getElementById('delete-image-container');
    var deleteImageCheckbox = document.getElementById('delete-image');
    var editImageInput = document.getElementById('edit-image');
    var addImageInput = document.getElementById('add-image');
    var originalImageName = '';

    // FAQ search functionality
    faqSearch.addEventListener('input', function () {
        console.log("Searching FAQ");
        var query = faqSearch.value.toLowerCase();
        var hasResults = false;

        faqItems.forEach(function (item) {
            var question = item.querySelector('h3').textContent.toLowerCase();
            var answer = item.querySelector('p').textContent.toLowerCase();

            if (question.includes(query) || answer.includes(query)) {
                item.style.display = 'block';
                hasResults = true;
            } else {
                item.style.display = 'none';
            }
        });

        noResultsMessage.style.display = hasResults ? 'none' : 'block';
    });

    // Open edit FAQ modal
    document.querySelectorAll('.btn-edit-faq').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var faqId = btn.getAttribute('data-id');
            console.log("Editing FAQ ID: " + faqId);

            fetch('/app/college_experts/getFAQ?id=' + faqId)
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched FAQ data: ", data);
                    editFAQId.value = data.id;
                    editQuestion.value = data.question;
                    editAnswer.value = data.answer;

                    editFAQModal.style.display = 'flex';
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Delete FAQ item
    document.querySelectorAll('.btn-delete-faq').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var faqId = btn.getAttribute('data-id');
            console.log("Deleting FAQ ID: " + faqId);

            fetch('/app/college_experts/deleteFAQ?id=' + faqId, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log("FAQ deleted successfully");
                        var faqItem = btn.closest('.faq-item');
                        faqItem.remove();
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Open add FAQ modal
    document.querySelector('.btn-add-faq').addEventListener('click', function () {
        console.log("Opening add FAQ modal");
        addFAQModal.style.display = 'flex';
    });

    // Close modals
    closeButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            console.log("Closing modal");
            btn.closest('.modal').style.display = 'none';
        });
    });

    // Close modals on outside click
    window.addEventListener('click', function (event) {
        if (event.target === editFAQModal) {
            editFAQModal.style.display = 'none';
        } else if (event.target === addFAQModal) {
            addFAQModal.style.display = 'none';
        } else if (event.target === editExpertModal) {
            editExpertModal.style.display = 'none';
        } else if (event.target === addExpertModal) {
            addExpertModal.style.display = 'none';
        }
    });

    // Function to validate email
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Function to validate phone number (example for French phone numbers)
    function validatePhone(phone) {
        var re = /^[\d\s]+$/;
        return re.test(phone);
    }    

    // Function to display error messages
    function displayErrorMessage(message, form) {
        var errorMessageElement = form.querySelector('.error_message');
        if (!errorMessageElement) {
            errorMessageElement = document.createElement('div');
            errorMessageElement.classList.add('error_message');
            form.prepend(errorMessageElement);
        }
        errorMessageElement.textContent = message;
    }

    // Function to clear error messages
    function clearErrorMessage(form) {
        var errorMessageElement = form.querySelector('.error_message');
        if (errorMessageElement) {
            errorMessageElement.remove();
        }
    }

    // Add FAQ form submission
    addFAQForm.addEventListener('submit', function (event) {
        event.preventDefault();
        console.log("Submitting add FAQ form");
        var formData = new FormData(addFAQForm);

        fetch('/app/college_experts/addFAQ', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log("FAQ added successfully: ", data);
                var newFAQ = document.createElement('div');
                newFAQ.classList.add('faq-item');
                newFAQ.innerHTML = `
                    <h3>${data.faq.question}</h3>
                    <p>${data.faq.answer}</p>
                    ${isAdmin ? `<button class="btn-edit-faq" data-id="${data.faq.id}">Modifier</button>
                    <button class="btn-delete-faq" data-id="${data.faq.id}">Supprimer</button>` : ''}
                `;
                document.getElementById('faq-items').appendChild(newFAQ);
                addFAQModal.style.display = 'none';
                addFAQForm.reset();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Open edit expert modal
    document.querySelectorAll('.btn-edit-expert').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var expertId = btn.getAttribute('data-id');
            console.log("Editing Expert ID: " + expertId);

            if (expertId) {
                fetch('/app/college_experts/getExpert?id=' + expertId)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Fetched Expert data: ", data);
                        if (data && data.id) {
                            editExpertId.value = data.id;
                            editTitle.value = data.titre;
                            editDescription.value = data.description;
                            editPhone.value = data.phone;
                            editEmail.value = data.email;
                            document.getElementById('existing-image-url').value = data.image_url;

                            if (data.image_url) {
                                originalImageName = data.image_url.split('/').pop();
                                dropZoneEdit.querySelector('.drop-zone__prompt').textContent = originalImageName;
                                dropZoneEdit.classList.add('disabled');
                                editImageInput.disabled = true;
                                deleteImageContainer.style.display = 'block';
                            } else {
                                originalImageName = '';
                                dropZoneEdit.querySelector('.drop-zone__prompt').textContent = "Sélectionnez ou Déposer votre Fichier Ici";
                                dropZoneEdit.classList.remove('disabled');
                                editImageInput.disabled = false;
                                deleteImageContainer.style.display = 'none';
                            }

                            editExpertModal.style.display = 'flex';
                        } else {
                            console.error('Expert item not found for id:', expertId);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                console.error('No expert ID found on button click');
            }
        });
    });

    // Open add expert modal
    document.querySelector('.btn-add-expert').addEventListener('click', function () {
        console.log("Opening add Expert modal");
        addExpertModal.style.display = 'flex';
    });

    // Ajouter expert form submission
    addExpertForm.addEventListener('submit', function (event) {
        event.preventDefault();
        console.log("Submitting add Expert form");
        clearErrorMessage(addExpertForm);
        
        var email = addExpertForm.querySelector('#email').value;
        var phone = addExpertForm.querySelector('#phone').value;
        if (!validateEmail(email)) {
            displayErrorMessage("Invalid email address.", addExpertForm);
            return;
        }
        if (!validatePhone(phone)) {
            displayErrorMessage("Invalid phone number.", addExpertForm);
            return;
        }

        var formData = new FormData(addExpertForm);

        fetch('/app/college_experts/addExpert', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log("Expert added successfully: ", data);
                var newExpert = document.createElement('div');
                newExpert.classList.add('expert');
                newExpert.innerHTML = `
                    <h3>${data.expert.titre}</h3>
                    <p class="description">${data.expert.description}</p>
                    ${data.expert.image_url ? `<img src="${data.expert.image_url}" alt="${data.expert.titre}">` : ''}
                    <p class="phone">Phone: ${data.expert.phone}</p>
                    <p class="email">Email: ${data.expert.email}</p>
                    ${isAdmin ? `<button class="btn-edit-expert" data-id="${data.expert.id}">Modifier</button>
                    <button class="btn-delete-expert" data-id="${data.expert.id}">Supprimer</button>` : ''}
                `;
                var addButton = document.querySelector('.btn-add-expert');
                addButton.parentNode.insertBefore(newExpert, addButton);
                addExpertModal.style.display = 'none';
                addExpertForm.reset();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Edit expert form submission
    editExpertForm.addEventListener('submit', function (event) {
        event.preventDefault();
        console.log("Submitting edit Expert form");
        clearErrorMessage(editExpertForm);

        var email = editExpertForm.querySelector('#edit-email').value;
        var phone = editExpertForm.querySelector('#edit-phone').value;
        if (!validateEmail(email)) {
            displayErrorMessage("Invalid email address.", editExpertForm);
            return;
        }
        if (!validatePhone(phone)) {
            displayErrorMessage("Invalid phone number.", editExpertForm);
            return;
        }

        var formData = new FormData(editExpertForm);

        fetch('/app/college_experts/editExpert', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log("Expert updated successfully: ", data);
                var expertItem = document.querySelector(`.expert[data-id='${data.expert.id}']`);
                if (expertItem) {
                    expertItem.querySelector('h3').textContent = data.expert.titre;
                    expertItem.querySelector('p.description').textContent = data.expert.description;
                    expertItem.querySelector('p.phone').textContent = `Phone: ${data.expert.phone}`;
                    expertItem.querySelector('p.email').textContent = `Email: ${data.expert.email}`;
                    if (data.expert.image_url) {
                        var imgElement = expertItem.querySelector('img');
                        if (imgElement) {
                            imgElement.src = data.expert.image_url;
                            imgElement.alt = data.expert.titre;
                        } else {
                            var newImgElement = document.createElement('img');
                            newImgElement.src = data.expert.image_url;
                            newImgElement.alt = data.expert.titre;
                            expertItem.insertBefore(newImgElement, expertItem.querySelector('p'));
                        }
                    } else {
                        var imgElement = expertItem.querySelector('img');
                        if (imgElement) {
                            imgElement.remove();
                        }
                    }
                } else {
                    console.error('Expert item not found for id:', data.expert.id);
                }
                editExpertModal.style.display = 'none';
                editExpertForm.reset();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Delete expert item
    document.querySelectorAll('.btn-delete-expert').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var expertId = btn.getAttribute('data-id');
            console.log("Deleting Expert ID: " + expertId);

            fetch('/app/college_experts/deleteExpert?id=' + expertId, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log("Expert deleted successfully");
                        var expertItem = btn.closest('.expert');
                        expertItem.remove();
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Handle delete image checkbox
    deleteImageCheckbox.addEventListener('change', function () {
        if (this.checked) {
            console.log("Image delete checkbox checked");
            dropZoneEdit.querySelector('.drop-zone__prompt').textContent = "Sélectionnez ou Déposer votre Fichier Ici";
            dropZoneEdit.classList.remove('disabled');
            editImageInput.disabled = false;
        } else {
            if (originalImageName) {
                dropZoneEdit.querySelector('.drop-zone__prompt').textContent = originalImageName;
                dropZoneEdit.classList.add('disabled');
                editImageInput.disabled = true;
            }
        }
    });

    // Update drop zone title when a file is added
    addImageInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var fileName = this.files[0].name;
            console.log("Selected file for add: " + fileName);
            dropZoneAdd.querySelector('.drop-zone__prompt').textContent = fileName;
        }
    });

    editImageInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var fileName = this.files[0].name;
            console.log("Selected file for edit: " + fileName);
            dropZoneEdit.querySelector('.drop-zone__prompt').textContent = fileName;
        }
    });
});
