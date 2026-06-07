
/**
 * Toggles the state of a checkbox element and updates its `aria-checked` attribute.
 *
 * @param {HTMLInputElement} checkbox - The checkbox element to toggle.
 */
export const toggleCheckbox = (checkbox) => {
    if (!checkbox || !(checkbox instanceof HTMLInputElement) || checkbox.type !== 'checkbox') {
      console.warn("Invalid checkbox provided. Ensure it is a valid input of type 'checkbox'.");
      return;
    }

    // Toggle the checked state of the checkbox
    checkbox.checked = !checkbox.checked;

    // Update the `aria-checked` attribute based on the new state
    const isChecked = checkbox.checked;
    checkbox.setAttribute('aria-checked', isChecked.toString());
  };
