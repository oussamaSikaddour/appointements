import { toggleInertForChildElement } from '../../traits/Inert';

/**
 * Focuses the first non-hidden input or focusable label within a form.
 * @param {HTMLFormElement} form - The form element to search within.
 */
export const focusNonHiddenInput = (form) => {
  if (!form?.tagName || form.tagName.toLowerCase() !== 'form') return;

  let currentInput = form.querySelector('input'); // Start with the first input

  while (currentInput) {
    const focusableLabel = currentInput.nextElementSibling?.matches('label[tabindex="0"]');
    if (focusableLabel) {
      currentInput.nextElementSibling.focus();
      return;
    } else if (
      !currentInput.matches('[style*="display: none"]') &&
      !currentInput.hidden &&
      !currentInput.inert
    ) {
      currentInput.focus();
      return;
    }
    currentInput = currentInput.nextElementSibling;
  }
};

/**
 * Clears error messages when an input, select, or textarea gains focus.
 * @param {HTMLFormElement} [myForm=null] - The form element to attach event listeners to.
 */
export const clearErrorsOnFocus = (myForm = null) => {
  const form = myForm || document.querySelector('.form') || document.querySelector(myForm);
  if (!form) return;

  const inputs = form.querySelectorAll('input, select, textarea');
  inputs.forEach((input) => {
    input.addEventListener('focus', () => {
      const errors = form.querySelectorAll('.input__error');
      errors.forEach((error) => (error.innerHTML = ''));
    });
  });
};

/**
 * Toggles the slide effect on a form and manages inert state for child elements.
 */

export const slideForms = (forms) => forms?.classList.add("slide");
export const unslideForms = (forms) => forms?.classList.remove("slide");

export const setInert = (element) => element?.setAttribute("inert", "");
export const removeInert = (element) => element?.removeAttribute("inert");
