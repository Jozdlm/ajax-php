const API_URL = "http://localhost:3000/api/categories.php";
const tableBody = document.getElementById("tbody");

function main() {
  fetch(API_URL)
    .then((res) => res.json())
    .then((data) => console.log(data))
    .catch();
}

main();
