import { focusNonHiddenInput, removeInert, setInert, slideForms, unslideForms } from "../components/Form";
import despatchCustomEvent from "../../traits/DespatchCustomEvent";

// Constants


// Cache DOM elements
const registerForms = document.querySelector(".forms");
const registerFirstForm = document.querySelector(".form--1");
const registerSecondForm = document.querySelector(".form--2");
const REGISTRATION_EMAIL = "registration-email";

// Helper functions


const setRegistrationEmail = (email) => {
  try {
    localStorage.setItem(REGISTRATION_EMAIL, email);
  } catch (error) {
    console.error("Failed to set registration email:", error);
  }
};

const removeRegistrationEmail = () => localStorage.removeItem(REGISTRATION_EMAIL);

export const toggleReForms = (showFirstForm) => {
  if (showFirstForm) {
    unslideForms(registerForms);
    removeInert(registerFirstForm);
    setInert(registerSecondForm);
  } else {
    slideForms(registerForms);
    setInert(registerFirstForm);
    removeInert(registerSecondForm);
  }
};

// Initialize multi-form registration


// Handle first form submission
export const handleRegisterFirstForm = () => {
  document.addEventListener("first-step-succeeded", (event) => {


    const email  = event.detail[0];

    if (!email) {
      console.error("Email is missing in first-step-succeeded event.");
      return;
    }

    toggleReForms(false);
    setRegistrationEmail(email);

    despatchCustomEvent?.("email-registration-is-set", { email });

    registerForms.addEventListener("transitionend", () => {
      focusNonHiddenInput(registerSecondForm);
    }, { once: true });
  });
};

// Handle second form submission
export const handleRegisterSecondForm = () => {
  document.addEventListener("second-step-succeeded", () => {
    toggleReForms(true);
    removeRegistrationEmail();
  });
};
