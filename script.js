const userReviewsElement = document.getElementById('user-reviews');

function getRandomUsers() {
    fetch('https://randomuser.me/api/?results=3')
        .then(response => response.json())
        .then(data => {
            const users = data.results;
            userReviewsElement.innerHTML = '';

            users.forEach((user, index) => {
                const name = `${user.name.first} ${user.name.last}`;
                const review = `${generateRandomReview()}`;
                const imageUrl = user.picture.large;

                const userReviewElement = document.createElement('div');
                userReviewElement.classList.add('user-review');
                userReviewElement.innerHTML = `
                    <img class="user-image" src="${imageUrl}" alt="User Image">
                    <div class="user-details">
                        <h2>${name}</h2>
                        <p>${review}</p>
                    </div>
                `;

                userReviewElement.style.animationDelay = `${index * 2}s`;
                userReviewsElement.appendChild(userReviewElement);
            });
        })
        .catch(error => console.error(error));
}

function generateRandomReview() {
    const reviews = [
        'Excelente producto, lo recomiendo ampliamente.',
        'No estoy satisfecho con la calidad, esperaba algo mejor.',
        'Cumple con mis expectativas, buen servicio.',
        'Podría mejorar en algunos aspectos, pero en general está bien.',
        'Una experiencia decepcionante, no volveré a comprar aquí.'
    ];

    return reviews[Math.floor(Math.random() * reviews.length)];
}

window.addEventListener('DOMContentLoaded', () => {
    getRandomUsers();
    const reviewsContainer = document.querySelector('.reviews-container');
    const reviewBox = document.querySelector('.review-box');
    const reviewContainer = document.querySelector('.review-container');
    const containerHeight = reviewsContainer.offsetHeight;
    const boxHeight = reviewBox.offsetHeight;

    if (boxHeight < containerHeight) {
        reviewContainer.style.height = `${containerHeight}px`;
    }
});