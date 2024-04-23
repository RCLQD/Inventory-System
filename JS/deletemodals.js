function openDeleteModal(id) {
    var fullName = document.getElementById('name_' + id).textContent;
    document.getElementById('fullName').querySelector('strong').innerText = fullName;
    document.getElementById('DM-btn').setAttribute('href', 'delete.php?id=' + id);
    document.getElementById('Dmodal').showModal();
}
