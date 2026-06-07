/**
 * Handles keyboard events for navigation and actions within a list of HTML elements.
 *
 * @param {KeyboardEvent} event - The keyboard event triggered by the user.
 * @param {number} index - The index of the currently focused element.
 * @param {Function|null} keyFunctionHandler - Function to handle 'Enter' or 'Space' key actions.
 * @param {HTMLElement[]} htmlElementsArray - Array of focusable HTML elements.
 * @param {Function|null} escapeFunction - Function to handle the 'Escape' key action.
 */
export const handleKeyEvents = (event, index, keyFunctionHandler = null, htmlElementsArray, escapeFunction = null) => {
    if (!Array.isArray(htmlElementsArray) || htmlElementsArray.length === 0) {
      console.warn("Invalid htmlElementsArray provided. Ensure it is a non-empty array of HTMLElements.");
      return;
    }

    const { key } = event;
    const currentIndex = index;
    const lastIndex = htmlElementsArray.length - 1;

    // Helper function to focus an element safely
    const focusElement = (element) => {
      if (element && element instanceof HTMLElement) {
        element.focus();
      }
    };

    switch (key) {
      case 'Escape':
        if (typeof escapeFunction === 'function') {
          event.preventDefault();
          escapeFunction();
        }
        break;

      case 'Enter':
      case ' ':
        if (typeof keyFunctionHandler === 'function') {
          event.preventDefault();
          keyFunctionHandler();
        }
        break;

      case 'ArrowDown':
        event.preventDefault();
        if (currentIndex < lastIndex) {
          focusElement(htmlElementsArray[currentIndex + 1]);
        }
        break;

      case 'ArrowUp':
        event.preventDefault();
        if (currentIndex > 0) {
          focusElement(htmlElementsArray[currentIndex - 1]);
        }
        break;

      case 'Home':
        focusElement(htmlElementsArray[0]);
        break;

      case 'End':
        focusElement(htmlElementsArray[lastIndex]);
        break;

      default:
        break;
    }
  };
