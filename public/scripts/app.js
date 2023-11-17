const API_URL = "http://localhost:3000/api/categories.php";
const tableBody = document.getElementById("tbody");

function renderList(data) {
  tableBody.innerHTML = "";

  let docFragment = document.createDocumentFragment();

  data.forEach((item) => {
    let row = document.createElement("tr");
    
    row.innerHTML = `
      <td>${item.id}</td>
      <td>${item.name}</td>
      <td>${item.description}</td>
    `;

    docFragment.appendChild(row);
  });

  tableBody.appendChild(docFragment);
}

function main() {
  fetch(API_URL)
    .then((res) => res.json())
    .then((data) => renderList(data))
    .catch();
}

main();
