document.addEventListener('DOMContentLoaded', () => {
    const petsContainer = document.getElementById('pets-container');
    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');
    let currentIndex = 0;
    const petsPerPage = 1; // Set to display only 1 pet at a time
    let pets = [];

    // Fetch pet data from the server
    fetch('get_pets.php') // Create this PHP file to return all pet data in JSON format
        .then(response => response.json())
        .then(data => {
            pets = data;
            displayPets();
        })
        .catch(error => console.error('Error fetching pet data:', error));

    function displayPets() {
        petsContainer.innerHTML = ''; // Clear previous pets
        const endIndex = Math.min(currentIndex + petsPerPage, pets.length);
        
        for (let i = currentIndex; i < endIndex; i++) {
            const pet = pets[i];
            const petCard = document.createElement('div');
            petCard.classList.add('pet');
            petCard.innerHTML = `
                <img src="${pet.photo}" alt="${pet.name}">
                <h2>${pet.name}</h2>
                <p>Species: ${pet.species}</p>
                <p>Breed: ${pet.breed}</p>
                <p>Age: ${pet.age}</p>
                <p>Description: ${pet.description}</p>
                <a class="nav-button" href="apply.php?pet_id=${pet.pet_id}">Apply for Adoption</a>
            `;
            petsContainer.appendChild(petCard);
        }

        // Show/hide navigation buttons
        prevBtn.style.display = currentIndex > 0 ? 'block' : 'none';
        nextBtn.style.display = endIndex < pets.length ? 'block' : 'none';
    }

    nextBtn.addEventListener('click', () => {
        currentIndex += petsPerPage;
        displayPets();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex -= petsPerPage;
        displayPets();
    });
});
