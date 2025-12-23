// ==============================
// Data simulasi (localStorage fallback)
// ==============================

const sampleEvents = [
  {
    id: "ev1",
    title: "Konser Musik: Cahaya Senja",
    date: "2025-12-20",
    location: "Gedung Serbaguna, Jakarta",
    desc: "Konser musik indie dengan band-band lokal.",
    img: "../img/konser.jpg",
  },
  {
    id: "ev2",
    title: "Seminar Teknologi: Web Modern",
    date: "2026-01-15",
    location: "Aula Kampus",
    desc: "Seminar tentang perkembangan web modern dan praktik terbaik.",
    img: "../img/digital.jpg",
  },
];

// ==============================
// 👥 Sample akun pengguna default
// ==============================

const sampleUsers = [
  {
    id: "u1",
    name: "Budi",
    email: "user@example.com",
    pass: "123",
    role: "user",
  },
  {
    id: "u2",
    name: "Dewi",
    email: "organizer@example.com",
    pass: "123",
    role: "organizer",
  },
  {
    id: "u3",
    name: "Raka",
    email: "admin@example.com",
    pass: "123",
    role: "admin",
  },
  {
    id: "u4",
    name: "Sinta",
    email: "petugas@example.com",
    pass: "123",
    role: "checker",
  },
];

// ==============================
// 🔁 Load / simpan data ke localStorage
// ==============================

let events = JSON.parse(localStorage.getItem("events")) || sampleEvents;
let users = JSON.parse(localStorage.getItem("users")) || sampleUsers;
let orders = JSON.parse(localStorage.getItem("orders")) || [];
let currentUser = JSON.parse(localStorage.getItem("currentUser")) || null;

function saveData() {
  localStorage.setItem("events", JSON.stringify(events));
  localStorage.setItem("users", JSON.stringify(users));
  localStorage.setItem("orders", JSON.stringify(orders));
  if (currentUser) {
    localStorage.setItem("currentUser", JSON.stringify(currentUser));
  }
}
