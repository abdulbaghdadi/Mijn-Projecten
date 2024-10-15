document.addEventListener("DOMContentLoaded", function() {
    const categoryLinks = document.querySelectorAll(".category-menu .nav-link");
    const projects = document.querySelectorAll(".project");

    categoryLinks.forEach(link => {
      link.addEventListener("click", function(e) {
        e.preventDefault();
        const category = this.getAttribute("data-category");
        showProjects(category);
        setActiveCategory(this);
      });
    });

    function showProjects(category) {
      projects.forEach(project => {
        if (category === "all" || project.getAttribute("data-category") === category) {
          project.classList.add("show");
        } else {
          project.classList.remove("show");
        }
      });
    }

    function setActiveCategory(link) {
      categoryLinks.forEach(link => link.classList.remove("active"));
      link.classList.add("active");
    }

    showProjects("all");
  });