function openDeleteModal(id) {
    document.getElementById('DM-btn').setAttribute('href', 'delete.php?id=' + id);
    document.getElementById('Dmodal').showModal();
}