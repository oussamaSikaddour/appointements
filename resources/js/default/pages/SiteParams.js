import { focusNonHiddenInput, removeInert, setInert, slideForms, unslideForms } from "../components/Form";



// Cache DOM elements
const siteParametersForms = document.querySelector(".spForms");
const siteParametersFirstForm = document.querySelector(".form-sp-1");
const siteParametersSecondForm = document.querySelector(".form-sp-l");






export const toggleSPForms = (showFirstForm) => {
  if (showFirstForm) {
    unslideForms(siteParametersForms);
    removeInert(siteParametersFirstForm);
    setInert(siteParametersSecondForm);
  } else {
    slideForms(siteParametersForms);
    setInert(siteParametersFirstForm);
    removeInert(siteParametersSecondForm);
  }
};

// Initialize multi-form registration


// Handle first form submission
export const handleSiteParametersFirstForm = () => {
  document.addEventListener("sp-first-step-succeeded", (event) => {



    toggleSPForms(false);


    siteParametersForms.addEventListener("transitionend", () => {
      focusNonHiddenInput(siteParametersSecondForm);
    }, { once: true });
  });
};

// Handle second form submission
export const handleSiteParametersLastForm = () => {
  document.addEventListener("sp-second-step-succeeded", () => {
    toggleSPForms(true);
    removeRegistrationEmail();
  });
};
