 // Sidebar Toggle Logic
 document.getElementById("toggleSidebar").addEventListener("click", function() {
     var sidebar = document.getElementById("sidebar");
     var mainContent = document.getElementById("main-content");

     sidebar.classList.toggle("show");
     mainContent.classList.toggle("shifted");

     // Toggle the main content visibility in mobile view
     if (window.innerWidth <= 768) { // Check if it's mobile view
         mainContent.classList.toggle("hidden");
     }

     // Toggle icon change
     var icon = this.querySelector("i");
     icon.classList.toggle("fa-bars");
     icon.classList.toggle("fa-arrow-right");
 });