import { focusNonHiddenInput } from "../components/Form";
import {  handleTriggerKeyEvents, manageTabTriggers } from "../components/Tabs";
import despatchCustomEvent from "../../traits/DespatchCustomEvent";




export const manageUserModalTabs = () => {
  document.addEventListener('user-modal-tabs-event', function(event) {
    // Dispatch custom event for file upload
    despatchCustomEvent('fil-upload');

    // Get the user form and tab elements
    const userForm = document.querySelector('.form');
    const userTabsTriggers = userForm.querySelectorAll('.tab__trigger');
    const userTabsPanels = userForm.querySelectorAll('.tab__panel');

    // Focus the first non-hidden input in the form
    focusNonHiddenInput(userForm);

    // Initialize tabs' state and add event listeners
    manageTabTriggers(userTabsTriggers, userTabsPanels);

    userTabsTriggers.forEach((trigger, i) => {
      // Click event: Activate the clicked tab
      trigger.addEventListener("click", () => {
        userTabsTriggers.forEach((t) => t.classList.remove('active'));
        trigger.classList.add('active');
        manageTabTriggers(userTabsTriggers, userTabsPanels);  // Re-initialize tabs after click
      });

      // Keydown event: Handle ArrowRight and ArrowLeft for tab navigation
      trigger.addEventListener("keydown", (e) => {
        if (e.key === "ArrowRight" || e.key === "ArrowLeft") {
          handleTriggerKeyEvents(e, i, userTabsTriggers, userTabsPanels);
        }
      });
    });

    // Optionally trigger the first tab manually to ensure it's selected by default
    userTabsTriggers[0]?.click();
  });
};
