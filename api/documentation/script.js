legendEdit();
      tableEdit();
      // Crea un'istanza Sortable per ciascuna tabella semplice
      document.querySelectorAll("table tbody").forEach(function (tbody) {
        new Sortable(tbody, {
          handle: ".dragHandle", // Definisce l'elemento di trascinamento
          ghostClass: "highlight-orange_background",
          animation: 150,
        });
      });

      function tableEdit() {
        // Seleziona tutti i tbody nelle tabelle con classe 'simple-table'
        var tbodies = document.querySelectorAll(".simple-table tbody");

        // Itera su ogni tbody
        tbodies.forEach(function (tbody) {
          // Seleziona tutti i <tr> all'interno del tbody corrente
          var rows = tbody.querySelectorAll("tr");

          // Itera su ogni riga
          rows.forEach(function (row) {
            // Seleziona il primo e l'ultimo <td> all'interno della riga corrente
            var firstCell = row.querySelector("td:first-child");
            var lastCell = row.querySelector("td:last-child");

            // Se la cella esiste, aggiunge l'elemento per trascinare
            if (firstCell) {
              firstCell.insertAdjacentHTML(
                "beforeend",
                "<div class='dragHandle removable'>☰</div>"
              );
            }

            // Se la cella esiste, caggiunge l'elemento per eliminare
            if (lastCell) {
              lastCell.insertAdjacentHTML(
                "beforeend",
                "<button class='deleteRow removable' onclick='eliminaRiga(this)'> 🗑 </button>"
              );
            }
          });
        });
      }

      function legendEdit() {
        var listItems = document.querySelectorAll("#legend li");

        // Itera su ogni elemento <li>
        listItems.forEach(function (listItem) {
          // Crea un nuovo elemento <button>
          listItem.innerHTML +=
            "<button class='addRow removable' onclick='aggiungiFunzione(this)''>➕</button>";
        });
      }

      function aggiungiRiga(bottone) {
        var table = bottone.parentNode.getElementsByTagName("table")[0];
        var tbody = table.getElementsByTagName("tbody")[0];
        var newRow = tbody.rows[0].cloneNode(true); // Clona la prima riga

        tbody.appendChild(newRow); // Aggiunge la riga clonata alla tabella
      }

      function eliminaRiga(bottone) {
        var row = bottone.parentNode.parentNode;
        row.parentNode.removeChild(row);

        // Crea un elemento di input invisibile
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";

        // Aggiunge l'elemento al body, mette il focus su di esso, e poi lo rimuove
        document.body.appendChild(tempInput);
        tempInput.focus();
        document.body.removeChild(tempInput);
      }

      function aggiungiOggetto() {
        // Crea un nuovo elemento <li>
        var newObjectList = document.createElement("li");
        let id = uuidv4();
        newObjectList.innerHTML =
          "<span contenteditable>Oggetto</span>:<a href='#" +
          id +
          "'>➡️</a> <ol></ol> <button class='addRow removable' onclick='aggiungiFunzione(this)''>➕</button>";

        // Aggiungi l'elemento alla lista
        document.getElementById("legend").appendChild(newObjectList);

        // Crea un nuovo elemento <article>
        var newObject = document.createElement("article");
        newObject.innerHTML =
          "<h1 id='" +
          id +
          "' contenteditable>Oggetto</h1><div class='indented'><blockquote contenteditable>Descrizione nuovo oggetto</blockquote>";
        // Aggiungi l'elemento al main
        document.getElementById("main").appendChild(newObject);
      }

      function aggiungiFunzione(button) {
        // Trova la sottolista associata al pulsante corrente
        var subList = button.parentElement.querySelector("ol");

        // Crea un nuovo elemento di lista
        var newListItem = document.createElement("li");
        newListItem.innerHTML =
          '<span contenteditable>Nuovo elemento</span> <a href="#' +
          uuidv4() +
          '">➡️</a>';

        // Aggiungi il nuovo elemento alla sottolista
        subList.appendChild(newListItem);
      }

      function uuidv4() {
        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
          /[xy]/g,
          function (c) {
            var r = (Math.random() * 16) | 0,
              v = c == "x" ? r : (r & 0x3) | 0x8;
            return v.toString(16);
          }
        );
      }

      function saveAll() {
        // Crea una copia dell'intero DOM
        let clone = document.documentElement.cloneNode(true);

        // Trova e rimuovi gli elementi indesiderati
        let unwantedElements = clone.querySelectorAll(".removable");
        unwantedElements.forEach(function (element) {
          element.parentNode.removeChild(element);
        });

        const params = JSON.stringify({
          Body: clone.outerHTML,
        });
        fetch("https://myvet.it/documentation/update", {
          method: "POST",
          body: params,
        })
          .then((response) => response.json())
          .then((data) => console.log(data));
      }
    