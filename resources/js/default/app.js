import '../bootstrap';

import {clearErrorsOnFocus, focusNonHiddenInput}from "./components/Form.js"
import Lang from './components/Lang.js';
import Navigation from './components/Nav.js';

import Tooltip from './components/Tooltip.js';
import {toggleCheckbox}from './components/CheckBoxes.js'
import {checkRadio} from './components/RadioButtons'
import DialogBox from './components/dialogBox.js';
import FileInput from './components/fileUpload.js';
import MainMenu from './components/mainMenu.js';
import Modal from './components/modal.js';
import { handleSiteParametersFirstForm,handleSiteParametersLastForm, toggleSPForms} from './pages/SiteParams.js';
import { setAriaAttributes } from '../traits/Aria.js';
import { handleForgotPasswordFirstForm ,handleForgotPasswordSecondForm, toggleFPForms } from './pages/ForgetPassword.js';
import {handleRegisterFirstForm,handleRegisterSecondForm, toggleReForms } from './pages/Register.js';
import { manageUserModalTabs } from './modals/User.js';
import { toggleInertForAllExceptOpenedElement } from '../traits/Inert.js';
import Combobox from './components/Combobox.js';
import Table from './components/Table.js';
import { hideLoader, Loader } from './components/Loader.js';
import despatchCustomEvent from '../traits/DespatchCustomEvent.js';
const REGISTRATION_EMAIL = "registration-email";



Lang();
Navigation();
Loader();
Modal();
MainMenu();
DialogBox();
FileInput();
handleForgotPasswordFirstForm()
handleForgotPasswordSecondForm()
handleSiteParametersFirstForm()
handleSiteParametersLastForm()
handleRegisterFirstForm();
handleRegisterSecondForm();

manageUserModalTabs();
Combobox()
Table()
Tooltip()






document.addEventListener('DOMContentLoaded', function() {
    const currentForm= document.querySelector(".form");
    if(currentForm){
      focusNonHiddenInput(currentForm);
    }
    hideLoader()

const registrationEmail = localStorage.getItem(REGISTRATION_EMAIL);

toggleFPForms(true)
toggleSPForms(true)
if (registrationEmail) {
          despatchCustomEvent?.("email-registration-is-set", { email: registrationEmail });
          toggleReForms(false);
    } else {
          toggleReForms(true);
    }
});



document.addEventListener('form-submitted', function(event) {
    const form = event.detail?.form
    if(form){
        clearErrorsOnFocus(form)
    }else{
        clearErrorsOnFocus()
    }
    })






document.addEventListener('radio-button-checked-event', function(event) {
const {radioButton} = event.detail
if(radioButton){
    checkRadio(radioButton)
}
})
document.addEventListener('radio-button-checked-event', function(event) {
const {checkBox} = event.detail
console.log(checkBox)
if(checkBox){
    toggleCheckbox(checkBox)
}
})




document.addEventListener('set-aria-attributes-event', function(event) {
const {hidden,tabIndex,element} = event.detail
 setAriaAttributes(hidden,tabIndex,element)
})


document.addEventListener('toggle-inert-for-all-except-opened-element', function(event) {
const {element,className} = event.detail
toggleInertForAllExceptOpenedElement(element, className)
})


document.addEventListener('init-tooltips',()=>{
    Tooltip()
})
document.addEventListener('init-table',()=>{
  Table()
})
document.addEventListener('init-combobox',()=>{
   Combobox()
})
