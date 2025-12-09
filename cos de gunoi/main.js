document.addEventListener("DOMContentLoaded", () => {
    fetch('backend/recommended_events.php')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById("recommended-events");
  
        if (data.length === 0) {
          container.innerHTML = "<p class='text-center'>Momentan nu există recomandări.</p>";
          return;
        }
  
        data.forEach(event => {
          const card = `
            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="images/main js1.jpeg" class="card-img-top" alt="${event.nume}">
                <div class="card-body">
                  <h5 class="card-title">${event.nume}</h5>
                  <p class="card-text">${event.descriere.substring(0, 100)}...</p>
                  <a href="events-details-public.html?id=${event.id}" class="btn btn-outline-primary">Vezi Detalii</a>
                </div>
              </div>
            </div>`;
          container.innerHTML += card;
        });
      })
      .catch(err => {
        console.error("Eroare la încărcarea evenimentelor recomandate:", err);
      });
  });
  