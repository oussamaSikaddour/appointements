
import {toggleInertForAllExceptOpenedElement} from '../../traits/Inert'
import {setAriaAttributes} from '../../traits/Aria'
import despatchCustomEvent from '../../traits/DespatchCustomEvent';


 const closeDialog = (dialog) => {
    dialog.classList.remove("open");
    const isOpen = dialog.classList.contains("open");
    setAriaAttributes(!isOpen, isOpen ? "0" : "-1", dialog);
    despatchCustomEvent('close-dialog');
    toggleInertForAllExceptOpenedElement(dialog, "open");
  };

const DialogBox = () => {
    document.addEventListener('open-dialog', function (event) {
      const boxCloser = document.querySelector(".box__closer");
      const dialog = document.querySelector(".box");

      // Add 'open' class to the dialog and update ARIA attributes
      dialog.classList.add("open");
      const isOpen = dialog.classList.contains("open");
      setAriaAttributes(!isOpen, isOpen ? "0" : "-1", dialog);
      toggleInertForAllExceptOpenedElement(dialog, "open");

      // Focus on the close button when the dialog opens
      boxCloser.focus();

      // Close the dialog when the close button is clicked
      boxCloser.addEventListener("click", () => closeDialog(dialog));
    });

    // Listen for 'close-dialog-box' event to close the dialog
    document.addEventListener('dialog-will-be-close', function (event) {
      const dialog = document.querySelector(".box");
      closeDialog(dialog);
    });
  };
export default DialogBox;
