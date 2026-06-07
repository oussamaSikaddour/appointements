/**
 * Updates the state of a tab trigger and its corresponding panel.
 * @param {number} index - The index of the trigger and panel.
 * @param {boolean} isActive - Whether the trigger is active.
 * @param {HTMLElement[]} triggers - Array of tab trigger elements.
 * @param {HTMLElement[]} panels - Array of tab panel elements.
 */


const updateTriggerState = (index, isActive, triggers, panels) => {
    const trigger = triggers[index];
    const panel = panels[index];

    if (!trigger || !panel) return;

    // Update accessibility attributes and tabindex
    trigger.setAttribute("aria-selected", isActive);
    trigger.setAttribute("tabindex", isActive ? "0" : "-1");
    panel.setAttribute("tabindex", isActive ? "0" : "-1");

    // Toggle active state and visibility
    trigger.classList.toggle("active", isActive);
    panel.style.display = isActive ? "flex" : "none";
  };



  /**
 * Activates a specific tab trigger and deactivates all others.
 * @param {number} index - The index of the trigger to activate.
 * @param {HTMLElement[]} triggers - Array of tab trigger elements.
 * @param {HTMLElement[]} panels - Array of tab panel elements.
 */
const activateTrigger = (index, triggers, panels) => {
    triggers.forEach((_, i) => {
      const isActive = index === i;
      updateTriggerState(i, isActive, triggers, panels);
    });
    triggers[index]?.focus();
  };



/**
 * Handles key events for tab triggers (e.g., ArrowRight, ArrowLeft).
 * @param {Event} event - The keydown event.
 * @param {number} index - The index of the currently focused trigger.
 * @param {HTMLElement[]} triggers - Array of tab trigger elements.
 * @param {HTMLElement[]} panels - Array of tab panel elements.
 */
export const handleTriggerKeyEvents = (event, index, triggers, panels) => {
    const { key } = event;
    const lastIndex = triggers.length - 1;

    switch (key) {
      case 'ArrowRight':
        event.preventDefault();
        if (index < lastIndex) activateTrigger(index + 1, triggers, panels);
        break;
      case 'ArrowLeft':
        event.preventDefault();
        if (index > 0) activateTrigger(index - 1, triggers, panels);
        break;
      default:
        // Optional: Add handling for other keys if needed
        break;
    }
  };



  export const manageTabTriggers = (triggers, panels) => {
    let activeIndex = triggers.findIndex(trigger => trigger.classList.contains("active"));
    if (activeIndex === -1) activeIndex = 0; // If no active tab, default to the first one
    activateTrigger(activeIndex, triggers, panels);
  };





