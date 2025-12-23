function logout() {
  localStorage.removeItem("currentUser");
  window.location.href = "index.html";
}

function renderEvents(containerId) {
  const container = document.getElementById(containerId);
  container.innerHTML = "";
  events.forEach((ev) => {
    const card = document.createElement("div");
    card.className = "col-md-4";
    card.innerHTML = `
      <div class="card event-card shadow-sm">
        <img src="${ev.img}" class="card-img-top" alt="">
        <div class="card-body">
          <h5 class="card-title">${ev.title}</h5>
          <p class="small text-muted">${ev.date} • ${ev.location}</p>
          <p class="card-text">${ev.desc}</p>
          <a href="event.html?id=${ev.id}" class="btn btn-primary btn-sm">Lihat Detail</a>
        </div>
      </div>`;
    container.appendChild(card);
  });
}
