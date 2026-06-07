import {handleKeyEvents} from "../../traits/KeyEventHandlers";
import { toggleInertForChildElement } from "../../traits/Inert";


/**
 * Toggles the inert state of the dropdown menu for mobile view.
 * @param {HTMLElement} dropDownMenu - The dropdown menu element.
 */
const toggleSubMenuPhoneInert = (dropDownMenu) => {
    const menuItems = dropDownMenu.querySelector(".nav__items--sub");
    toggleInertForChildElement(dropDownMenu, menuItems, "clicked", true);
  };

/**
 * Toggles the visibility and ARIA attributes of the submenu.
 * @param {HTMLElement} navButton - The button controlling the visibility of the submenu.
 */
const toggleNavSubMenuVisibility = (navButton) => {
    const subItems = navButton.nextElementSibling;
    if (subItems) {
      const isExpanded = navButton.classList.contains("clicked");
      navButton.setAttribute("aria-expanded", isExpanded);
      navButton.setAttribute("aria-hidden", !isExpanded);
      navButton.toggleAttribute("hidden", !isExpanded);
    }
  };


  /**
 * Toggles the visibility and inert state of the navigation button and its submenu.
 * @param {number} index - The index of the navigation button.
 * @param {NodeList} navButtons - All the navigation buttons.
 */
const toggleNavButtonVisibility = (index, navButtons) => {
    const currentNavButton = navButtons[index];
    navButtons.forEach((navButton, i) => {
      if (navButton !== currentNavButton) {
        navButton.classList.remove("clicked");
        navButton.parentElement.classList.remove("clicked");
      } else {
        navButton.classList.toggle("clicked");
        navButton.parentElement.classList.toggle("clicked");
      }
      toggleNavSubMenuVisibility(navButton);
      toggleSubMenuPhoneInert(navButton.parentElement);
    });
  };



  /**
 * Handles the keydown event for menu items.
 * @param {number} index - The index of the navigation button.
 * @param {NodeList} navButtons - All the navigation buttons.
 */
const quiteMenu = (index,navButtons) => {
 toggleNavButtonVisibility(index,navButtons);
  navButtons[index].focus()
};

const handleMenuItemKeyDown = (index,navButtons) => {
  const menu = navButtons[index].nextElementSibling;
  const menuItems = Array.from(menu.querySelectorAll("[role='menuitem']"));
  menuItems[0]?.focus();

  menu.addEventListener('keydown', (event) => {
    const pressedItem = event.target.closest('[role="menuitem"]');
    const i = menuItems.indexOf(pressedItem);
    handleKeyEvents(event, i, null, menuItems,()=>quiteMenu(index,navButtons));
  });
};



/**
 * Manages the visibility and inert state of dropdown navigation buttons.
 * @param {NodeList} navButtons - All the navigation buttons.
 */
const manageDropDownNavButtons = (navButtons) => {
    navButtons.forEach((navButton, index) => {
      navButton.addEventListener("click", () => toggleNavButtonVisibility(index, navButtons));
      navButton.addEventListener("keydown", (e) => {
        if (e.code === "Space" || e.code === "Enter") {
          toggleNavButtonVisibility(index, navButtons);
        }
        if (navButton.classList.contains("clicked")) {
          handleMenuItemKeyDown(index, navButtons);
        }
      });
    });
  };


  /**
 * Manages the inert state for the dropdown menus in mobile view.
 * @param {NodeList} dropDownMenus - All the dropdown menus.
 */
const manageInertSubNavMenuState = (dropDownMenus) => {
    dropDownMenus?.forEach((d) => toggleSubMenuPhoneInert(d));
  };




/**
 * Toggles the mobile navigation menu visibility.
 * @param {HTMLElement} HumBtn - The hamburger button.
 * @param {HTMLElement} navPhone - The mobile navigation container.
 */
const toggleNavPhoneMenu = (HumBtn, navPhone) => {
    HumBtn.classList.toggle("open");
    navPhone.classList.toggle("open");
    const expanded = HumBtn.classList.contains("open");
    HumBtn.setAttribute("aria-expanded", expanded);
    HumBtn.setAttribute("aria-hidden", !expanded);
    navPhone.toggleAttribute("hidden", !expanded);
  };







  const Navigation =()=>{
    const navButtons = Array.from(document.querySelectorAll(".nav__btn--dropdown"));
    const HumBtn = document.querySelector(".nav__humb");
    const navPhone= document.querySelector(".nav--phone")
    const dropDownMenus = document.querySelectorAll(".nav--phone .nav__item--dropDown")
    HumBtn?.addEventListener('click', () => {
        toggleNavPhoneMenu(HumBtn,navPhone)
    });
    manageDropDownNavButtons(navButtons)
    manageInertSubNavMenuState(dropDownMenus)
}
export default Navigation;
