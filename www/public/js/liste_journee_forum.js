document.addEventListener('DOMContentLoaded', function () {
    // Fonction de recherche
    window.searchTable = function() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('inscriptionTable');
        const tr = table.getElementsByTagName('tr');
        let noResult = true;

        for (let i = 1; i < tr.length; i++) {
            const tdFirstName = tr[i].getElementsByTagName('td')[0];
            const tdLastName = tr[i].getElementsByTagName('td')[1];
            const tdEmail = tr[i].getElementsByTagName('td')[2];
            const tdAddress = tr[i].getElementsByTagName('td')[3];
            const tdCity = tr[i].getElementsByTagName('td')[4];
            const tdPostalCode = tr[i].getElementsByTagName('td')[5];
            const tdDate = tr[i].getElementsByTagName('td')[6];

            if (tdFirstName && tdLastName && tdEmail && tdAddress && tdCity && tdPostalCode && tdDate) {
                const firstNameValue = tdFirstName.textContent || tdFirstName.innerText;
                const lastNameValue = tdLastName.textContent || tdLastName.innerText;
                const emailValue = tdEmail.textContent || tdEmail.innerText;
                const addressValue = tdAddress.textContent || tdAddress.innerText;
                const cityValue = tdCity.textContent || tdCity.innerText;
                const postalCodeValue = tdPostalCode.textContent || tdPostalCode.innerText;
                const dateValue = tdDate.textContent || tdDate.innerText;

                if (
                    firstNameValue.toLowerCase().indexOf(filter) > -1 || 
                    lastNameValue.toLowerCase().indexOf(filter) > -1 || 
                    emailValue.toLowerCase().indexOf(filter) > -1 ||
                    addressValue.toLowerCase().indexOf(filter) > -1 ||
                    cityValue.toLowerCase().indexOf(filter) > -1 ||
                    postalCodeValue.toLowerCase().indexOf(filter) > -1 ||
                    dateValue.toLowerCase().indexOf(filter) > -1
                ) {
                    tr[i].style.display = "";
                    noResult = false;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        document.getElementById('noResultMessage').style.display = noResult ? "" : "none";
    };

    // Fonction de tri
    window.sortTable = function(columnIndex) {
        const table = document.getElementById('inscriptionTable');
        let switching = true;
        let direction = "asc"; 
        let switchCount = 0;
        const rows = table.rows;

        while (switching) {
            switching = false;
            let shouldSwitch;
            let i;
            for (i = 1; i < rows.length - 1; i++) {
                shouldSwitch = false;
                const x = rows[i].getElementsByTagName('td')[columnIndex];
                const y = rows[i + 1].getElementsByTagName('td')[columnIndex];

                if (x && y) {
                    if (direction === "asc") {
                        if (new Date(x.innerHTML) > new Date(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (direction === "desc") {
                        if (new Date(x.innerHTML) < new Date(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchCount++;
            } else {
                if (switchCount === 0 && direction === "asc") {
                    direction = "desc";
                    switching = true;
                }
            }
        }
    };
});
