document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("darkModeToggle");
  const icon = document.getElementById("darkModeIcon");
  const body = document.body;
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("toggleSidebar");

  function updateCKEditorTheme(isDark) {
    if (typeof CKEDITOR !== "undefined") {
      Object.values(CKEDITOR.instances).forEach(editor => {
        if (editor.document) {
          editor.document.getBody().setStyle(
            "background-color",
            isDark ? "#0F172A" : "#FFFFFF"
          );

          editor.document.getBody().setStyle(
            "color",
            isDark ? "#E5E7EB" : "#000000"
          );
        }
      });
    }
  }

  function updateDarkMode() {
    const isDark = localStorage.getItem("darkMode") === "enabled";
    const tables = document.querySelectorAll(".table");
    const thead = document.getElementById("tableHeader");
    const sidebarLinks = document.querySelectorAll(".sb-link");

    body.classList.toggle("dark-mode", isDark);

    tables.forEach(table => {
      table.classList.toggle("table-dark", isDark);
    });

    if (sidebar) {
      sidebar.classList.toggle("bg-dark-custom", isDark);
      sidebar.classList.toggle("text-light-custom", isDark);
    }

    sidebarLinks.forEach(link => {
      link.classList.toggle("bg-dark-custom", isDark);
      link.classList.toggle("text-light", isDark);
    });

    if (sidebarToggle) {
      sidebarToggle.classList.toggle("btn-dark", isDark);
    }

    if (icon) {
      icon.classList.toggle("bi-moon-stars-fill", !isDark);
      icon.classList.toggle("bi-sun-fill", isDark);
    }

    updateCKEditorTheme(isDark);
  }

  updateDarkMode();

  toggleBtn.addEventListener("click", function () {
    const isCurrentlyDark = localStorage.getItem("darkMode") === "enabled";
    localStorage.setItem( "darkMode", isCurrentlyDark ? "disabled" : "enabled");
    updateDarkMode();
  });

  // Quando qualquer CKEditor terminar de carregar
  if (typeof CKEDITOR !== "undefined") {
    CKEDITOR.on("instanceReady", function () {
      const isDark = localStorage.getItem("darkMode") === "enabled";
      updateCKEditorTheme(isDark);
    });
  }
});