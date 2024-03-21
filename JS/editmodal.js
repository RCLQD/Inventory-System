function openEditModal(id) {
    var name = document.getElementById('name_' + id).innerText;
    var address = document.getElementById('address_' + id).innerText;
    var licNo = document.getElementById('licno_' + id).innerText;
    var expDate = document.getElementById('expDate_' + id).innerText;

    document.getElementById('edit_FName').value = name;
    document.getElementById('edit_Address').value = address;
    document.getElementById('edit_LicNo').value = licNo;
    document.getElementById('edit_EDate').value = expDate;

    document.getElementById('driver_id').value = id;

    document.getElementById('Emodal').showModal();
}

document.getElementById('ECM-btn').addEventListener('click', function() {
    document.getElementById('Emodal').close();
});