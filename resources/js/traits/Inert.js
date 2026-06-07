/**
 * Toggles the "inert" attribute for an element.
 *
 * @param {HTMLElement} element - The target element.
 * @param {boolean} state - Whether to set ("true") or remove ("false") the "inert" attribute. Defaults to false.
 */
const toggleInert = (element, state = false) => {
    if (!element || !(element instanceof HTMLElement)) return;
    state ? element.setAttribute("inert", "") : element.removeAttribute("inert");
  };


  /**
 * Toggles the "inert" attribute based on the presence of a class on the element.
 *
 * @param {HTMLElement} element - The target element.
 * @param {string} className - The class name to check for.
 * @param {boolean} invertState - Whether to invert the logic of the state. Defaults to false.
 */
export const toggleInertWhenState = (element, className, invertState = false) => {
    if (!element || !(element instanceof HTMLElement)) return;
    const hasClassName = element.classList.contains(className);
    toggleInert(element, invertState ? !hasClassName : hasClassName);
  };



  /**
 * Toggles the "inert" attribute for a child element based on the parent's class state.
 *
 * @param {HTMLElement} element - The parent element to check for the class.
 * @param {HTMLElement} childElement - The child element to toggle "inert" on.
 * @param {string} className - The class name to check for on the parent element.
 * @param {boolean} invertState - Whether to invert the logic of the state. Defaults to false.
 */
export const toggleInertForChildElement = (element, childElement, className, invertState = false) => {
    if (!element || !childElement || !(element instanceof HTMLElement) || !(childElement instanceof HTMLElement)) return;
    const hasClassName = element.classList.contains(className);
    toggleInert(childElement, invertState ? !hasClassName : hasClassName);
  };


  /**
 * Toggles the "inert" attribute for all body children except a specified opened element.
 *
 * @param {HTMLElement} openedElement - The element to exclude from having "inert" toggled.
 * @param {string} className - The class name to check for on the opened element.
 * @param {boolean} invertState - Whether to invert the logic of the state. Defaults to false.
 */
export const toggleInertForAllExceptOpenedElement = (openedElement, className, invertState = false) => {
    if (!openedElement || !(openedElement instanceof HTMLElement)) return;

    const elementState = openedElement.classList.contains(className);
    const bodyChildren = Array.from(document.body.children);

    bodyChildren.forEach((element) => {
      if (element !== openedElement) {
        const shouldBeInert = invertState ? !elementState : elementState;
        toggleInert(element, shouldBeInert);
      }
    });
  };




