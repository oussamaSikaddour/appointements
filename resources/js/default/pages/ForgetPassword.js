import { focusNonHiddenInput, removeInert, setInert, slideForms, unslideForms } from "../components/Form";
import despatchCustomEvent from "../../traits/DespatchCustomEvent";



// Cache DOM elements
const forgotPasswordForms = document.querySelector(".fpForms");
const forgotPasswordFirstForm = document.querySelector(".form-fp-1");
const forgotPasswordSecondForm = document.querySelector(".form-fp-l");

// Helper functions





export const toggleFPForms = (showFirstForm) => {
  if (showFirstForm) {
    unslideForms(forgotPasswordForms);
    removeInert(forgotPasswordFirstForm);
    setInert(forgotPasswordSecondForm);
  } else {
    slideForms(forgotPasswordForms);
    setInert(forgotPasswordFirstForm);
    removeInert(forgotPasswordSecondForm);
  }
};

// Initialize multi-form registration


// Handle first form submission
export const handleForgotPasswordFirstForm = () => {
  document.addEventListener("fp-first-step-succeeded", (event) => {


    const email  = event.detail[0];

    if (!email) {
      console.error("Email is missing in first-step-succeeded event.");
      return;
    }

    toggleFPForms(false);
    despatchCustomEvent?.("email-forgot-password-is-set", { email });

    forgotPasswordForms.addEventListener("transitionend", () => {
      focusNonHiddenInput(forgotPasswordSecondForm);
    }, { once: true });
  });
};

// Handle second form submission
export const handleForgotPasswordSecondForm = () => {
  document.addEventListener("fp-second-step-succeeded", () => {
    toggleFPForms(true);
    removeRegistrationEmail();
  });
};
