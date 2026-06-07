/**
 * Updates ARIA attributes and tabindex for a given HTML element.
 *
 * @param {boolean} hidden - Whether the element is hidden from assistive technologies.
 * @param {number|string} tabindex - Tabindex value to set, determining the focus order.
 * @param {HTMLElement} element - The target HTML element.
 */
export const setAriaAttributes = (hidden, tabindex, element) => {
    if (!element || !(element instanceof HTMLElement)) {
      console.warn("Invalid element provided. Ensure the element is an instance of HTMLElement.");
      return;
    }

    // Apply attributes only if values are provided
    hidden !== undefined && element.setAttribute("aria-hidden", hidden);
    tabindex !== undefined && element.setAttribute("tabindex", tabindex);
  };
