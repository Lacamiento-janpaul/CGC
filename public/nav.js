(function () {
  var header = document.querySelector(".site-header");
  var toggle = document.querySelector(".nav-toggle");
  var nav = document.querySelector("#primary-nav");
  if (!header || !toggle || !nav) return;

  var links = nav.querySelectorAll("a");

  function setOpen(open) {
    toggle.setAttribute("aria-expanded", open ? "true" : "false");
    toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    toggle.classList.toggle("is-open", open);
    nav.classList.toggle("is-open", open);
  }

  toggle.addEventListener("click", function (e) {
    e.stopPropagation();
    setOpen(!nav.classList.contains("is-open"));
  });

  links.forEach(function (link) {
    link.addEventListener("click", function () {
      setOpen(false);
    });
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") setOpen(false);
  });

  document.addEventListener("click", function (e) {
    if (!header.contains(e.target) && nav.classList.contains("is-open")) {
      setOpen(false);
    }
  });
})();

// Admin user menu dropdown
(function () {
  var userToggle = document.querySelector(".admin-user-toggle");
  var userDropdown = document.querySelector(".admin-user-dropdown");
  if (!userToggle || !userDropdown) return;

  var menuLinks = userDropdown.querySelectorAll(".admin-menu-link");

  function setUserMenuOpen(open) {
    userToggle.setAttribute("aria-expanded", open ? "true" : "false");
    userDropdown.classList.toggle("is-open", open);
  }

  userToggle.addEventListener("click", function (e) {
    e.stopPropagation();
    setUserMenuOpen(!userDropdown.classList.contains("is-open"));
  });

  menuLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      setUserMenuOpen(false);
    });
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") setUserMenuOpen(false);
  });

  document.addEventListener("click", function (e) {
    if (!userToggle.contains(e.target) && !userDropdown.contains(e.target) && userDropdown.classList.contains("is-open")) {
      setUserMenuOpen(false);
    }
  });
})();

