import { toggleInertForAllExceptOpenedElement } from '../../traits/Inert';
import { setAriaAttributes } from '../../traits/Aria';
import { focusNonHiddenInput } from './Form';
import despatchCustomEvent from '../../traits/DespatchCustomEvent';

const closeModal = (modal, openModalBtn) => {
  if (!modal.classList.contains("open")) return;

  // Close the modal
  modal.classList.remove("open");

  // Update ARIA attributes
  setAriaAttributes(false, "-1", modal);

  // Dispatch custom event
  despatchCustomEvent('model-will-be-close');

  // Restore page interactivity
  toggleInertForAllExceptOpenedElement(modal, "open");

  // Return focus to the button that opened the modal
  openModalBtn.focus();
};

const openModal = (modal, openModalBtn) => {
  if (modal.classList.contains("open")) return;

  // Open the modal
  modal.classList.add("open");

  // Update ARIA attributes
  setAriaAttributes(true, "0", modal);

  // Restrict page interactivity
  toggleInertForAllExceptOpenedElement(modal, "open");

  // Focus the first non-hidden input in the modal (if present)
  setTimeout(() => {
    const modalForm = modal.querySelector(".form");
    focusNonHiddenInput(modalForm);
  }, 500);
};

const Modal = () => {
  document.addEventListener('open-modal', () => {
    const modal = document.querySelector(".modal");
    const openModalBtn = document.querySelector(".modal__opener");
    const closeModalBtn = modal.querySelector(".modal__closer");

    // Open the modal
    openModal(modal, openModalBtn);

    // Attach close modal event to the close button
    closeModalBtn.addEventListener("click", () => closeModal(modal, openModalBtn), { once: true });
  });
};

export default Modal;
