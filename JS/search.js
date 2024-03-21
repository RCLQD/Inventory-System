function searchTable() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        var rowMatches = false;
        
        for (j = 0; j < td.length - 1; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rowMatches = true;
                    var regex = new RegExp(filter, 'gi');
                    td[j].innerHTML = txtValue.replace(regex, function(match) {
                        return '<span class="highlight">' + match + '</span>';
                    });
                } else {
                    td[j].textContent = txtValue;
                }
            }
        }
        
        if (rowMatches) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
