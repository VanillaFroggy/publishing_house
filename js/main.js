function openCreateForm() {
    document.getElementById("btnOpenCreateForm").style.display = "none";
    document.getElementById("createForm").style.display = "block";
    document.getElementById("grid").style.display = "none";
}

function closeCreateForm() {
    document.getElementById("createForm").style.display = "none";
    document.getElementById("btnOpenCreateForm").style.display = "block";
    document.getElementById("grid").style.display = "block";
}

function openEditForm() {
    document.getElementById("editForm").style.display = "block";
    document.getElementById("uploadImageForm").style.display = "block";
    document.getElementById("grid").style.display = "none";
}

function closeEditForm() {
    document.getElementById("editForm").style.display = "none";
    document.getElementById("uploadImageForm").style.display = "none";
}

function dropContent() {
    document.getElementById("myDropdown").classList.toggle("show");
}
  
// Закрыть раскрывающийся список, если пользователь щелкнет за его пределами.
window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
        if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
        }
    }
}

function openProfileForm() {
    document.getElementById("profileForm").style.display = "block";
    document.getElementById("profileDiv").style.display = "none";
}

function closeProfileForm() {
    document.getElementById("profileForm").style.display = "none";
    document.getElementById("profileDiv").style.display = "block";
}