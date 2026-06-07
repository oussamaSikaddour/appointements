import {  handleKeyEvents} from '../../traits/KeyEventHandlers'
import { toggleInertWhenState} from '../../traits/Inert'

/**
 * Toggles the ARIA and visibility states for the menu button.
 * @param {HTMLElement} btn - The menu button element.
 */
const updateButtonState = (btn) => {
    const expanded = btn.classList.contains("clicked");
    btn.setAttribute("aria-expanded", expanded);
    btn.setAttribute("aria-hidden", !expanded);
    btn.classList.toggle("clicked");
  };


  /**
 * Toggles the menu visibility and updates the inert state of other elements.
 * @param {HTMLElement} btn - The clicked menu button.
 * @param {NodeList} mainMenuButtons - All menu buttons.
 * @param {HTMLElement} menu - The menu container.
 */
const toggleMenuVisibility = (btn, mainMenuButtons, menu) => {
    mainMenuButtons.forEach(b => {
      if (b !== btn) {
        b.classList.remove("clicked");
        updateButtonState(b);  // Update button states when menu is toggled
      }
    });
    menu.classList.toggle("open");
    updateButtonState(btn);  // Update the clicked button state
    toggleInertWhenState(menu, "open", true);  // Apply inertness when menu is open
  };



const quiteMainMenu = (index, mainMenuButtons,menu) => {
  toggleMenuVisibility(mainMenuButtons[index],mainMenuButtons,menu);
  mainMenuButtons[index].focus()
 };

 const handleMenuItemKeyDown = (index,mainMenuButtons,menu) => {
   const menuItems = Array.from(menu.querySelectorAll("[role='menuitem']"));

   menuItems[0]?.focus();
   menu.addEventListener('keydown', (event) => {
     const pressedItem = event.target.closest('[role="menuitem"]');
     const i = menuItems.indexOf(pressedItem);
     handleKeyEvents(event, i, null, menuItems,()=>quiteMainMenu(index,mainMenuButtons,menu));
   });
 };



 // Set initial state of menu inertness


 const MainMenu = () => {
    const mainMenuButtons = document.querySelectorAll(".menu__btn");
    const menu = document.querySelector(".menu");

    if (menu) {
      mainMenuButtons.forEach((btn, index) => {
        // Click event to toggle the menu
        btn.addEventListener('click', () => toggleMenuVisibility(btn, mainMenuButtons, menu));

        // Keydown event to handle keyboard interactions
        btn.addEventListener('keydown', (e) => {
          if (e.code === 'Space' || e.code === 'Enter') {
            e.preventDefault();
            toggleMenuVisibility(btn, mainMenuButtons, menu);
            if (btn.classList.contains("clicked")) {
              handleMenuItemKeyDown(index, mainMenuButtons, menu);
            }
          }
        });
      });

      // Initially set inert state for the menu
      toggleInertWhenState(menu, "open", true);
    }
  };

export default MainMenu
