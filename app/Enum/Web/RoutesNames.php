<?php

namespace App\Enum\Web;

/**
 * Enum defining named routes for use across the application.
 * Using enums helps ensure consistency and avoids hardcoded strings.
 */
enum RoutesNames: string
{
    // Public & Guest Routes
    case INDEX = 'index';                         // Landing or homepage route
    case LOG_OUT = 'logout';                      // Logout route
    case IS_ON_MAINTENANCE_MODE = 'maintenanceMode'; // Check if the site is in maintenance
    case SITE_PARAMETERS = 'siteParameters';      // View or update general site parameters
    case SET_LANG = 'setLang';                    // Route for changing language

    // Authentication Routes
    case LOGIN = 'login';                         // Login page
    case REGISTER = 'register';                   // Registration page
    case FORGET_PASSWORD = 'forgetPassword';      // Forgot password route

    // User Routes
    case USER_ROUTE = 'home';                     // Default user dashboard/home
    case PROFILE = 'profile';                     // User profile page
    case CHANGE_PASSWORD = 'changePassword';      // Route to change user password
    case CHANGE_EMAIL = 'changeEmail';            // Route to change user email
    case MEDICAL_FILE_ROUTE = 'medicalFile';            // Route to change user email
    case TOGGLE_ACCOUNT_STATUS ='ToggleActiveState';

    // Super Admin Routes
    case SUPER_ADMIN_ROUTE = 'superAdminSpace';   // Super admin dashboard
    case LANDING_PAGE = 'landingPage';            // Landing page management
    case BANKS = 'banks';                         // Bank management
    case OCCUPATION_FIELDS='occupationFields';
    case WILAYATES='wilayates';
    case WILAYA='WILAYA';


    case MESSAGES = 'messages';                   // View or manage contact messages
    case GENERAL_INFOS = 'generalInfos';          // General settings and info
    case MANAGE_HERO = 'heroScene';               // Hero section management
    case MANAGE_ABOUT_US = 'aboutUsScene';        // About Us section
    case MANAGE_OUR_QUALITIES = "ourQualities";   // Our Qualities management
    case MANAGE_SOCIALS = 'socials';              // Social media links

    // Admin Routes
    case ADMIN_ROUTE = 'adminSpace';              // Admin dashboard
   case ESTABLISHMENT_ROUTE='establishmentDetails';
    case MENUS_ROUTE = "menus";                   // All menus listing
    case MENU_ROUTE = "menu";                     // Single menu view/edit
    case SLIDERS_ROUTE = "sliders";               // Sliders management
    case SLIDER_ROUTE = "slides";                 // Slides management

    // Shared/Content Routes
    case ARTICLES_ROUTE = "articles";             // Articles management
    case TRENDS_ROUTE = "trends";                 // Trends management


      // establishment Admin Routes
    case ESTABLISHMENT_ADMIN_ROUTE = 'establishmentAdminSpace';
    case SERVICES_ROUTE = 'services';




      // establishment Coord Routes
    case APPOINTMENTS_LOCATION_ADMIN_ROUTE = 'appointmentsLocationAdminSpace';



      // service Admin Routes
    case SERVICE_ADMIN_ROUTE = 'serviceAdminSpace';
    case MANAGE_APPOINTMENTS_LOCATION_ADMINS_ROUTE = 'manageALAdmins';


      // doctor Space
    case DOCTOR_ROUTE = 'doctorSpace';
    case MEDICAL_FILES_ROUTE = 'medicalFiles';
    case PATIENT_VISITS_ROUTE = 'patientVisit';


}
