$(function () {
  toogle();
  setActiveLink();
  setVerticalDivider();
});

function setVerticalDivider() {
  const accordion = $(".sub-menu.active");

  if (accordion !== undefined) {
    $(accordion).append('<div class="sub-menu-vertical-divider"></div>');

    const subMenuHeight = $(accordion).outerHeight() - 25;

    $(accordion)
      .find(".sub-menu-vertical-divider")
      .css({
        height: subMenuHeight + "px",
      });
  }
}

function toggleAccordion(collapseId) {
  const collapseElement = document.getElementById(collapseId);

  const accordionToogle = collapseElement.previousElementSibling;

  const iconElement =
    collapseElement.previousElementSibling.querySelector(".accordion-icon");

  collapseElement.classList.toggle("active");

  if (collapseElement.classList.contains("active")) {
    iconElement.innerHTML = "▲"; // Chevron atas
    // accordionToogle.classList.add("link-active");
  } else {
    iconElement.innerHTML = "▼"; // Chevron bawah
    // accordionToogle.classList.remove("link-active");
  }

  setVerticalDivider();
}

// Function to check and add class 'sub-link-active' to the appropriate nav-link
function setActiveLink() {
  const links = document.getElementsByClassName("nav-link");

  let currentUrl = window.location.href;
  currentUrl = currentUrl.split("/");
  currentUrl = currentUrl[currentUrl.length -1];

  const linkWithoutAccordion = document.getElementsByClassName("links");

  for (let i = 0; i < linkWithoutAccordion.length; i++) {
    const link = linkWithoutAccordion[i];
    const href = link.getAttribute("href");

    if (currentUrl === href) {
      $(link.getElementsByClassName("accordion-toggle")).addClass(
        "link-active"
      );

      return;
    }
  }

  

  for (let i = 0; i < links.length; i++) {
    const link = links[i];
    const href = link.getAttribute("href");

    

    if (currentUrl === href) {

      

      link.classList.add("sub-link-active");
      // Assuming the accordion parent is the 'ul' element with class 'sub-menu'
      const accordion = link.closest(".sub-menu");
      accordion.classList.add("show");

      // Open the parent accordion if nested within another submenu
      const parentAccordion = accordion.closest(".accordion-content");
      if (parentAccordion) {
        const parentLinkId = parentAccordion.id;
        toggleAccordion(parentLinkId);

        const collapseElement = document.getElementById(parentLinkId);
        const accordionToogle = collapseElement.previousElementSibling;
        accordionToogle.classList.add("link-active");
      }
    }
  }
}

function toogle() {
  $("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
  });
}
