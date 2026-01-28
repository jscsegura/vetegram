<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/change/language/{lang}', 'HomeController@language')->name('change.language');

Route::get('/social/loginFacebook', 'Auth\LoginController@loginFacebook')->name('login.facebook');
Route::get('/social/loginGoogle', 'Auth\LoginController@loginGoogle')->name('login.google');
Route::get('/social/registerFacebook/{rol}', 'Auth\RegisterController@registerFacebook')->name('register.facebook');
Route::get('/social/registerGoogle/{rol}', 'Auth\RegisterController@registerGoogle')->name('register.google');
Route::get('/social/callback/{network}', 'Auth\LoginController@loginSocialNetwork')->name('callback.social.login');
Route::get('/social/register/callback/{network}/{rol}', 'Auth\RegisterController@registerSocialNetwork')->name('callback.social.register');

Route::post('/register/get-location', 'Auth\RegisterController@getLocation')->name('get.location');
Route::post('/register/get-breed', 'Auth\RegisterController@getBreed')->name('get.breed');

Route::middleware(['checkLang'])->group(function () {
    Route::get('/', 'HomeController@landing')->name('home.landing');
    Route::post('/sendcontact', 'HomeController@sendcontact')->name('home.contact');

    Route::get('/ingress', 'HomeController@index')->name('home.index');
    Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
    Route::post('/login-ajax', 'Auth\LoginController@loginAjax')->name('login.loginAjax');
    Route::get('/forgot', 'Auth\LoginController@forgot')->name('forgot');
    Route::post('/forgot', 'Auth\ForgotPasswordController@sendResetLink')->name('forgot.submit');
    Route::get('/password/reset/{token}/{email}', 'Auth\ForgotPasswordController@reset')->name('reset.passsword');
    Route::post('/password/reset', 'Auth\ForgotPasswordController@update')->name('password.update');
    Route::get('/logout', 'Auth\LoginController@logout')->name('login.logout');

    Route::get('/usertype', 'Auth\RegisterController@usertype')->name('usertype');
    Route::get('/getHaciendaInfo', 'Auth\RegisterController@getHaciendaInfo')->name('getHaciendaInfo');
    Route::get('/signup/{type}', 'Auth\RegisterController@signup')->name('signup');
    Route::post('/register', 'Auth\RegisterController@register')->name('register');
    Route::get('/register/complete', 'Auth\RegisterController@complete')->name('register.complete');
    Route::get('/register/confirm/{token}', 'Auth\RegisterController@confirm')->name('register.confirm');

    Route::get('/pet/permit-access/{code}', 'PetController@setAccess')->name('pets.setAccess');

    Route::get('/view-attach/{id}', 'PetController@viewAttach')->name('pet.viewattach');
    Route::get('/entry-vaccine/{id}', 'PetController@entryVaccine')->name('pets.entryVaccine');

    Route::post('/appointment-create-vaccine', 'AppointmentController@createVaccine')->name('appoinment.createVaccine');

    Route::post('/appointment-send-recipe', 'AppointmentController@sendRecipe')->name('appoinment.sendRecipe');
    Route::get('/appointment-download-recipe/{id}', 'AppointmentController@downloadRecipe')->name('appoinment.downloadRecipe');

    Route::get('/response-tilopay', 'HomeController@responseTilopay')->name('home.responseTilopay');
    Route::get('/paymessage/{code}/{text}', 'HomeController@paymessage')->name('home.paymessage');

    Route::get('/search/{vet_id?}', 'HomeController@search')->name('search.index');

    Route::middleware(['checkWeb'])->group(function () {
        Route::get('/register/complete-profile', 'Auth\RegisterController@completeProfile')->name('register.complete-profile');
        Route::post('/register/complete-save', 'Auth\RegisterController@completeProfileSave')->name('register.complete-save');
        Route::post('/register/check-vetcode', 'Auth\RegisterController@checkVetCode')->name('check.vetcode');
        Route::post('/register/create-owner', 'Auth\RegisterController@createOwner')->name('register.create-owner');
        Route::post('/register/create-pet', 'Auth\RegisterController@createPet')->name('register.create-pet');

        Route::get('/dash', 'HomeController@dash')->name('dash');
        Route::get('/admin', 'HomeController@admin')->name('admin');
        Route::get('/notifications', 'HomeController@notifications')->name('notifications');
        Route::post('/notification-delete', 'HomeController@removeNotification')->name('notification.remove');
        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::post('/profile-update', 'HomeController@updateProfile')->name('profile.update');
        Route::post('/profile-update-photo', 'HomeController@updatePhoto')->name('profile.updatePhoto');
        Route::post('/profile-set-signature', 'HomeController@setSignature')->name('profile.setSignature');
        Route::post('/profile-set-notifications', 'HomeController@setNotifications')->name('profile.setNotifications');

        Route::get('/appointments/{month?}/{year?}/{userid?}', 'AppointmentController@index')->name('appointment.index');
        Route::get('/appointment-history/{month?}/{year?}/{userid?}', 'AppointmentController@history')->name('appointment.history');
        Route::get('/appointment-schedule/{userid?}/{from?}/{to?}/{type?}', 'AppointmentController@schedule')->name('appointment.schedule');
        Route::get('/appointment-add', 'AppointmentController@add')->name('appointment.add');
        Route::post('/appointment-store', 'AppointmentController@store')->name('appointment.store');
        Route::get('/appointment-view/{id}', 'AppointmentController@view')->name('appointment.view');
        Route::get('/appointment-edit/{id}', 'AppointmentController@edit')->name('appointment.edit');
        Route::get('/appointment-start/{id}', 'AppointmentController@start')->name('appointment.start');
        Route::get('/appointment-endinvoice', 'AppointmentController@endinvoice')->name('appointment.endinvoice');
        Route::post('/appointment-update', 'AppointmentController@update')->name('appointment.update');
        Route::post('/appointment-get-hours', 'AppointmentController@getHours')->name('appoinment.getHours');
        Route::post('/appointment-reserve-hour', 'AppointmentController@reserveHour')->name('appoinment.reserveHour');
        Route::post('/appointment-get-client', 'AppointmentController@getClient')->name('appoinment.getClient');
        Route::post('/appointment-set-client', 'AppointmentController@setClient')->name('appoinment.setClient');
        Route::post('/appointment-save-note', 'AppointmentController@saveNote')->name('appoinment.saveNote');
        Route::post('/appointment-save-reminder', 'AppointmentController@saveReminder')->name('appoinment.saveReminder');
        Route::post('/appointment-update-reminder', 'AppointmentController@updateReminder')->name('appoinment.updateReminder');
        Route::post('/appointment-save-attach', 'AppointmentController@saveAttach')->name('appoinment.saveAttach');
        Route::post('/appointment-delete-attach', 'AppointmentController@deleteAttach')->name('appoinment.deleteAttach');
        Route::post('/appointment-get-recipe-data', 'AppointmentController@getRecipeData')->name('appoinment.getRecipeData');
        Route::post('/appointment-save-recipe', 'AppointmentController@saveRecipe')->name('appoinment.saveRecipe');
        Route::post('/appointment-update-recipe', 'AppointmentController@updateRecipe')->name('appoinment.updateRecipe');
        Route::post('/appointment-delete-recipe', 'AppointmentController@deleteRecipe')->name('appoinment.deleteRecipe');
        Route::post('/appointment-cancel-or-reschedule', 'AppointmentController@cancelOrReschedule')->name('appoinment.cancelOrReschedule');
        Route::get('/appointment-print-recipe/{id}/{later?}', 'AppointmentController@printRecipe')->name('appoinment.printrecipe');
        Route::post('/appointment-finish', 'AppointmentController@finish')->name('appoinment.finish');
        Route::post('/appointment-get-countries', 'AppointmentController@getCountries')->name('appoinment.getCountries');
        Route::get('/appointment-cancel/{id}', 'AppointmentController@appointmentCancel')->name('appoinment.cancelDirect');
        Route::get('/appointment-reschedule/{id}', 'AppointmentController@appointmentReschedule')->name('appoinment.rescheduleDirect');
        Route::post('/appointment-getvaccinedata', 'AppointmentController@getVaccineData')->name('appoinment.getVaccineData');
        Route::post('/appointment-send-attach', 'AppointmentController@sendAttach')->name('appoinment.sendAttach');
        Route::post('/appointment-send-entry-vaccine', 'AppointmentController@sendEntryVaccine')->name('appoinment.sendEntryVaccine');

        Route::get('/setting', 'SettingController@index')->name('sett.index');
        Route::get('/setting-edit/{date?}', 'SettingController@edit')->name('sett.edit');
        Route::post('/setting-addhour', 'SettingController@addHour')->name('sett.addHour');
        Route::post('/setting-delhour', 'SettingController@delHour')->name('sett.delHour');
        Route::post('/setting-settemplate', 'SettingController@setTemplate')->name('sett.setTemplate');
        Route::post('/setting-addavailablehour', 'SettingController@addAvailableHour')->name('sett.addAvailableHour');
        Route::post('/setting-delavailablehour', 'SettingController@delAvailableHour')->name('sett.delAvailableHour');
        Route::post('/setting-delallhour', 'SettingController@delAllHour')->name('sett.delAllHour');
        Route::post('/setting-updatemode', 'SettingController@updateMode')->name('sett.updateMode');
        Route::post('/setting-generatetemplate', 'SettingController@generateTemplate')->name('sett.generateTemplate');
        Route::get('/setting-grooming', 'SettingController@grooming')->name('sett.grooming');
        Route::post('/setting-grooming-save', 'SettingController@groomingSave')->name('sett.groomingSave');
        Route::get('/setting-physicalexam', 'SettingController@physicalexam')->name('sett.physicalexam');
        Route::post('/setting-physicalexam-store', 'SettingController@physicalexamStore')->name('sett.physicalexamStore');


        Route::get('/pet/detail/{id}', 'PetController@detail')->name('pet.detail');
        Route::get('/pet/vaccines/{id}', 'PetController@vaccines')->name('pet.vaccines');
        Route::get('/pet/desparat/{id}', 'PetController@desparat')->name('pet.desparat');
        Route::get('/pet/attach/{id}', 'PetController@attach')->name('pet.attach');
        Route::get('/pet/recipes/{id}', 'PetController@recipes')->name('pet.recipes');
        Route::get('/owners/{search?}', 'PetController@owners')->name('pet.owners');
        Route::get('/pet/history-download/{id}', 'PetController@downloadHistory')->name('pet.historyDownload');
        Route::post('/pet/get-access', 'PetController@getAccess')->name('pets.getAccess');

        Route::get('/inventory/list/{search?}', 'InventoryController@index')->name('inventory.index');
        Route::get('/inventory/add', 'InventoryController@add')->name('inventory.add');
        Route::post('/inventory/store', 'InventoryController@store')->name('inventory.store');
        Route::get('/inventory/edit/{id}', 'InventoryController@edit')->name('inventory.edit');
        Route::get('/inventory/history/{id}', 'InventoryController@history')->name('inventory.history');
        Route::post('/inventory/update', 'InventoryController@update')->name('inventory.update');
        Route::post('/inventory/delete', 'InventoryController@delete')->name('inventory.delete');
        Route::post('/inventory/change-enabled', 'InventoryController@changeEnabled')->name('inventory.changeEnabled');
        Route::get('/inventory/upload', 'InventoryController@upload')->name('inventory.upload');
        Route::post('/inventory/uploadxml', 'InventoryController@uploadxml')->name('inventory.uploadxml');
        Route::post('/inventory/previewXml', 'InventoryController@previewXml')->name('inventory.previewXml');
        Route::post('/inventory/storeXmlProducts', 'InventoryController@storeXmlProducts')->name('inventory.storeXmlProducts');

        Route::get('/schedule/menu', 'ScheduleController@menu')->name('schedule.menu');
        Route::get('/schedule/schedule', 'ScheduleController@schedule')->name('schedule.schedule');
        Route::get('/schedule/exception', 'ScheduleController@exception')->name('schedule.exception');
        Route::get('/schedule/configuration', 'ScheduleController@configuration')->name('schedule.configuration');
        Route::post('/schedule/store', 'ScheduleController@storeSchedule')->name('schedule.storeSchedule');
        Route::post('/schedule/update', 'ScheduleController@updateSchedule')->name('schedule.updateSchedule');

        Route::get('/schedule/extra/index/{search?}', 'ScheduleController@indexExtra')->name('schedule.extra.index');
        Route::get('/schedule/extra/add', 'ScheduleController@addExtra')->name('schedule.extra.add');
        Route::get('/schedule/extra/edit/{id}', 'ScheduleController@editExtra')->name('schedule.extra.edit');
        Route::post('/schedule/extra/store', 'ScheduleController@storeExtra')->name('schedule.extra.store');
        Route::post('/schedule/extra/delete', 'ScheduleController@deleteExtra')->name('schedule.extra.delete');
        Route::post('/schedule/extra/update', 'ScheduleController@updateExtra')->name('schedule.extra.update');

        Route::get('/schedule/exception/index/{search?}', 'ScheduleController@indexException')->name('schedule.exception.index');
        Route::get('/schedule/exception/add', 'ScheduleController@addException')->name('schedule.exception.add');
        Route::get('/schedule/exception/edit/{id}', 'ScheduleController@editException')->name('schedule.exception.edit');
        Route::post('/schedule/exception/store', 'ScheduleController@storeException')->name('schedule.exception.store');
        Route::post('/schedule/exception/delete', 'ScheduleController@deleteException')->name('schedule.exception.delete');
        Route::post('/schedule/exception/update', 'ScheduleController@updateException')->name('schedule.exception.update');

        Route::get('/schedule/configuration/add', 'ScheduleController@addConfiguration')->name('schedule.configuration.add');
        Route::get('/schedule/configuration/edit/{id}', 'ScheduleController@editConfiguration')->name('schedule.configuration.edit');
        Route::post('/schedule/configuration/store', 'ScheduleController@storeConfiguration')->name('schedule.configuration.store');
        Route::post('/schedule/configuration/update', 'ScheduleController@updateConfiguration')->name('schedule.configuration.update');



        Route::get('/adminuser/list/{search?}', 'UserController@index')->name('adminuser.index');
        Route::get('/adminuser/add', 'UserController@add')->name('adminuser.add');
        Route::post('/adminuser/store', 'UserController@store')->name('adminuser.store');
        Route::get('/adminuser/edit/{id}', 'UserController@edit')->name('adminuser.edit');
        Route::post('/adminuser/delete', 'UserController@delete')->name('adminuser.delete');
        Route::post('/adminuser/change-lock', 'UserController@changeLock')->name('adminuser.changeLock');

        Route::get('/adminpatient/list/{search?}', 'UserController@patient')->name('adminpatient.index');
        Route::get('/adminpatient/add', 'UserController@patientadd')->name('adminpatient.add');
        Route::post('/adminpatient/store', 'UserController@patientStore')->name('adminpatient.store');
        Route::get('/adminpatient/view/{id}', 'UserController@patientview')->name('adminpatient.view');
        Route::post('/adminpatient/update', 'UserController@patientUpdate')->name('adminpatient.update');

        Route::get('/book/hours/{vet_id}/{date?}', 'HomeController@book')->name('search.book');
        Route::get('/book-message/{id}', 'HomeController@bookmessage')->name('search.message');
        Route::post('/owner/saveAppoinment', 'HomeController@saveBook')->name('search.saveBook');
        Route::post('/owner/get-pet-data', 'HomeController@getPetData')->name('search.getPetData');
        Route::post('/owner/get-pet-data-images', 'HomeController@getPetDataImages')->name('search.getPetDataImages');

        Route::get('/pets', 'PetController@myPets')->name('pets.index');
        Route::post('/pets-save', 'PetController@savePet')->name('pets.savePet');
        Route::post('/pets-edit', 'PetController@editPet')->name('pets.editPet');
        Route::post('/pets-data', 'PetController@petData')->name('pets.petData');
        Route::post('/pets-savephoto', 'PetController@savePhoto')->name('pets.savePhoto');
        Route::post('/pets-delete', 'PetController@delete')->name('pets.delete');

        Route::get('/plan', 'HomeController@plan')->name('plan');
        Route::post('/plan-start', 'HomeController@startPlan')->name('home.startPlan');
        Route::get('/payment', 'HomeController@payment')->name('home.payment');
        Route::post('/cancel-pro', 'HomeController@cancelPro')->name('home.cancelPro');

        Route::get('/invoice/{month?}/{year?}/{billtype?}', 'InvoiceController@index')->name('invoice.index');
        Route::get('/invoice-create/{id?}', 'InvoiceController@create')->name('invoice.create');
        Route::get('/invoice-detail/{id}/{doctype}/{printer?}', 'InvoiceController@detail')->name('invoice.detail');
        Route::post('/invoice-store', 'InvoiceController@store')->name('invoice.store');
        Route::get('/invoice-proform', 'InvoiceController@proformas')->name('invoice.proform');
        Route::get('/invoice-proform-detail/{id}', 'InvoiceController@proformaDetail')->name('proform.detail');
        Route::get('/invoice-proform-edit/{id}', 'InvoiceController@proformaEdit')->name('proform.edit');
        Route::post('/invoice-resend', 'InvoiceController@resend')->name('invoice.resend');
        Route::post('/invoice-nc', 'InvoiceController@nc')->name('invoice.nc');
        Route::get('/invoice-uptake', 'InvoiceController@uptake')->name('invoice.uptake');
        Route::post('/invoice-detail-uptake', 'InvoiceController@uploadUptake')->name('process.uptake');
        Route::post('/invoice-save-uptake', 'InvoiceController@saveUptake')->name('process.uptakeSave');
        Route::get('/invoice-finish-uptake/{msgType?}/{message?}', 'InvoiceController@finishUptake')->name('invoice.uptakeFinish');
        Route::post('/invoice-delete', 'InvoiceController@delete')->name('invoice.delete');

        /*** Marketplace ***/
        Route::get('/adminstore', 'HomeController@adminstore')->name('adminstore');
        Route::get('/addproduct', 'HomeController@addproduct')->name('addproduct');
    });
});

Route::get('wpanel/logout', 'Wpanel\LoginController@logout')->name('wp.logout');
Route::post('wpanel/login', 'Wpanel\LoginController@login')->name('wp.login.submit');
Route::post('wpanel/forgot/submit', 'Wpanel\LoginController@forgotProcess')->name('wp.forgot.submit');

Route::middleware(['checkAdmin'])->prefix('wpanel')->name('wp.')->group(function () {
    Route::get('/', 'Wpanel\LoginController@index')->name('login');
    Route::get('forgot', 'Wpanel\LoginController@forgot')->name('login.forgot');
    Route::get('home', 'Wpanel\HomeController@index')->name('home');

    Route::get('/my/profile', 'Wpanel\HomeController@profile')->name('home.profile');
    Route::post('/save/profile', 'Wpanel\HomeController@profileUpdate')->name('home.save.profile');

    Route::resource('/users', 'Wpanel\UserController')->except(['destroy', 'show']);
    Route::get('/users/list', 'Wpanel\UserController@list')->name('users.list');
    Route::post('/users/enabled', 'Wpanel\UserController@enabled')->name('users.enabled');
    Route::post('/users/delete', 'Wpanel\UserController@delete')->name('users.delete');
    Route::post('/users/deletefile', 'Wpanel\UserController@deletefile')->name('users.deletefile');

    Route::resource('/specialties', 'Wpanel\SpecialtiesController')->except(['destroy', 'show']);
    Route::get('/specialties/list', 'Wpanel\SpecialtiesController@list')->name('specialties.list');
    Route::post('/specialties/enabled', 'Wpanel\SpecialtiesController@enabled')->name('specialties.enabled');
    Route::post('/specialties/delete', 'Wpanel\SpecialtiesController@delete')->name('specialties.delete');

    Route::resource('/language', 'Wpanel\LanguageController')->except(['destroy', 'show']);
    Route::get('/language/list', 'Wpanel\LanguageController@list')->name('language.list');
    Route::post('/language/enabled', 'Wpanel\LanguageController@enabled')->name('language.enabled');
    Route::post('/language/delete', 'Wpanel\LanguageController@delete')->name('language.delete');

    Route::get('/countries/index', 'Wpanel\CountryController@index')->name('countries.index');
    Route::get('/countries/list', 'Wpanel\CountryController@list')->name('countries.list');
    Route::post('/countries/enabled', 'Wpanel\CountryController@enabled')->name('countries.enabled');

    Route::resource('/animal-types', 'Wpanel\TypesController')->except(['destroy', 'show']);
    Route::get('/animal-types/list', 'Wpanel\TypesController@list')->name('animal-types.list');
    Route::post('/animal-types/enabled', 'Wpanel\TypesController@enabled')->name('animal-types.enabled');
    Route::post('/animal-types/delete', 'Wpanel\TypesController@delete')->name('animal-types.delete');

    Route::get('/animal-breed/show/{type}', 'Wpanel\BreedController@index')->name('animal-breed.index');
    Route::get('/animal-breed/list/{type}', 'Wpanel\BreedController@list')->name('animal-breed.list');
    Route::get('/animal-breed/create/{type}', 'Wpanel\BreedController@create')->name('animal-breed.create');
    Route::post('/animal-breed/store', 'Wpanel\BreedController@store')->name('animal-breed.store');
    Route::get('/animal-breed/edit/{id}', 'Wpanel\BreedController@edit')->name('animal-breed.edit');
    Route::post('/animal-breed/update/{id}', 'Wpanel\BreedController@update')->name('animal-breed.update');
    Route::post('/animal-breed/enabled', 'Wpanel\BreedController@enabled')->name('animal-breed.enabled');
    Route::post('/animal-breed/delete', 'Wpanel\BreedController@delete')->name('animal-breed.delete');

    Route::get('/animal-breed/images/{id}', 'Wpanel\BreedController@images')->name('animal-breed.images');
    Route::get('/animal-breed/create-image/{id}', 'Wpanel\BreedController@createImage')->name('animal-breed.createImage');
    Route::get('/animal-breed/imagelist/{id}', 'Wpanel\BreedController@imageList')->name('animal-breed.imagelist');
    Route::post('/animal-breed/store-image', 'Wpanel\BreedController@storeImage')->name('animal-breed.storeImage');
    Route::get('/animal-breed/edit-image/{id}', 'Wpanel\BreedController@editImage')->name('animal-breed.editImage');
    Route::post('/animal-breed/update-image/{id}', 'Wpanel\BreedController@updateImage')->name('animal-breed.updateImage');
    Route::post('/animal-breed/enabled-image', 'Wpanel\BreedController@enabledImage')->name('animal-breed.enabledImage');
    Route::post('/animal-breed/delete-image', 'Wpanel\BreedController@deleteImage')->name('animal-breed.deleteImage');
    Route::post('/animal-breed/delete-file', 'Wpanel\BreedController@deleteFile')->name('animal-breed.deletefile');

    Route::get('/settings', 'Wpanel\SettingController@index')->name('settings.index');
    Route::post('/settings/{id}', 'Wpanel\SettingController@update')->name('settings.update');
    Route::get('/setting-pro', 'Wpanel\SettingController@pro')->name('setting.pro');
    Route::get('/setting-pro/create', 'Wpanel\SettingController@proCreate')->name('setting.procreate');
    Route::post('/setting-pro/store', 'Wpanel\SettingController@proStore')->name('setting.prostore');
    Route::get('/setting-pro/{id}/edit', 'Wpanel\SettingController@proEdit')->name('setting.proedit');
    Route::post('/setting-pro/update/{id}', 'Wpanel\SettingController@proUpdate')->name('setting.proupdate');
    Route::post('/setting-pro/enabled', 'Wpanel\SettingController@proEnabled')->name('setting.proenabled');
    Route::post('/setting-pro/delete', 'Wpanel\SettingController@proDelete')->name('setting.prodelete');

    Route::get('/college', 'Wpanel\CollegeController@index')->name('college.index');
    Route::get('/college/list', 'Wpanel\CollegeController@list')->name('college.list');
    Route::get('/college/create', 'Wpanel\CollegeController@create')->name('college.create');
    Route::post('/college/store', 'Wpanel\CollegeController@store')->name('college.store');
    Route::get('/college/format', 'Wpanel\CollegeController@format')->name('college.format');

    Route::resource('/recipe-take', 'Wpanel\RecipeTakeController')->except(['destroy', 'show']);
    Route::get('/recipe-take/list', 'Wpanel\RecipeTakeController@list')->name('recipe-take.list');
    Route::post('/recipe-take/enabled', 'Wpanel\RecipeTakeController@enabled')->name('recipe-take.enabled');
    Route::post('/recipe-take/delete', 'Wpanel\RecipeTakeController@delete')->name('recipe-take.delete');

    Route::get('/veterinary/index', 'Wpanel\VeterinaryController@index')->name('veterinary.index');
    Route::get('/veterinary/list', 'Wpanel\VeterinaryController@list')->name('veterinary.list');
    Route::get('/veterinary/users/{id}', 'Wpanel\VeterinaryController@users')->name('veterinary.users');
    Route::get('/veterinary/listUsers', 'Wpanel\VeterinaryController@listUsers')->name('veterinary.listUsers');
    Route::post('/veterinary/lock', 'Wpanel\VeterinaryController@lock')->name('veterinary.lock');
    Route::post('/veterinary/enabled', 'Wpanel\VeterinaryController@enabled')->name('veterinary.enabled');
    Route::get('/veterinary/detail/{id}', 'Wpanel\VeterinaryController@detail')->name('veterinary.user');
    Route::get('/veterinary/pro/{id}', 'Wpanel\VeterinaryController@pro')->name('veterinary.pro');

    Route::get('/login/with/user/{id}', 'Wpanel\LoginController@loginWith')->name('login.with.user');

    Route::get('/client/index', 'Wpanel\ClientController@index')->name('client.index');
    Route::get('/client/list', 'Wpanel\ClientController@list')->name('client.list');
    Route::get('/client/detail/{id}', 'Wpanel\ClientController@detail')->name('client.detail');
    Route::post('/client/lock', 'Wpanel\ClientController@lock')->name('client.lock');
    Route::post('/client/enabled', 'Wpanel\ClientController@enabled')->name('client.enabled');

    Route::get('/logs/index', 'Wpanel\LogsController@index')->name('logs.index');
    Route::get('/logs/list', 'Wpanel\LogsController@list')->name('logs.list');
    Route::post('/logs/detail', 'Wpanel\LogsController@detail')->name('logs.detail');

    Route::get('/contact/index', 'Wpanel\ContactController@index')->name('contact.index');
    Route::get('/contact/list', 'Wpanel\ContactController@list')->name('contact.list');

    Route::resource('/slider', 'Wpanel\SliderController')->except(['destroy', 'show']);
    Route::get('/slider/list', 'Wpanel\SliderController@list')->name('slider.list');
    Route::post('/slider/enabled', 'Wpanel\SliderController@enabled')->name('slider.enabled');
    Route::post('/slider/delete', 'Wpanel\SliderController@delete')->name('slider.delete');
    Route::post('/slider/deletefile', 'Wpanel\SliderController@deletefile')->name('slider.deletefile');
    Route::post('/slider/deletefilemovil', 'Wpanel\SliderController@deletefileMovil')->name('slider.deletefileMovil');

    Route::resource('/service', 'Wpanel\ServiceController')->except(['destroy', 'show']);
    Route::get('/service/list', 'Wpanel\ServiceController@list')->name('service.list');
    Route::post('/service/enabled', 'Wpanel\ServiceController@enabled')->name('service.enabled');
    Route::post('/service/delete', 'Wpanel\ServiceController@delete')->name('service.delete');
    Route::post('/service/deletefile', 'Wpanel\ServiceController@deletefile')->name('service.deletefile');

    Route::resource('/about', 'Wpanel\AboutController')->except(['destroy', 'show']);
    Route::get('/about/list', 'Wpanel\AboutController@list')->name('about.list');
    Route::post('/about/enabled', 'Wpanel\AboutController@enabled')->name('about.enabled');
    Route::post('/about/delete', 'Wpanel\AboutController@delete')->name('about.delete');
    Route::post('/about/deletefile', 'Wpanel\AboutController@deletefile')->name('about.deletefile');
    Route::get('/about/intro', 'Wpanel\AboutController@intro')->name('about.intro');
    Route::post('/about/intro/{id}', 'Wpanel\AboutController@saveIntro')->name('about.saveintro');
    Route::post('/about/deletefileintro', 'Wpanel\AboutController@deletefileintro')->name('about.deletefileintro');

    Route::resource('/physical', 'Wpanel\PhysicalController')->except(['destroy', 'show']);
    Route::get('/physical/list', 'Wpanel\PhysicalController@list')->name('physical.list');
    Route::post('/physical/enabled', 'Wpanel\PhysicalController@enabled')->name('physical.enabled');
    Route::post('/physical/delete', 'Wpanel\PhysicalController@delete')->name('physical.delete');

    Route::get('/physical/options/{category}', 'Wpanel\PhysicalController@options')->name('physical.options');
    Route::get('/physical/list-options/{category}', 'Wpanel\PhysicalController@listOptions')->name('physical.listOptions');
    Route::get('/physical/create-options/{category}', 'Wpanel\PhysicalController@createOptions')->name('physical.createOptions');
    Route::post('/physical/store-options', 'Wpanel\PhysicalController@storeOptions')->name('physical.storeOptions');
    Route::get('/physical/{id}/edit-options', 'Wpanel\PhysicalController@editOptions')->name('physical.editOptions');
    Route::put('/physical/update-options/{id}', 'Wpanel\PhysicalController@updateOptions')->name('physical.updateOptions');
    Route::post('/physical/enabled-options', 'Wpanel\PhysicalController@enabledOptions')->name('physical.enabledOptions');
    Route::post('/physical/delete-options', 'Wpanel\PhysicalController@deleteOptions')->name('physical.deleteOptions');

    Route::get('/physical/suboptions/{option}', 'Wpanel\PhysicalController@suboptions')->name('physical.Suboptions');
    Route::get('/physical/list-suboptions/{option}', 'Wpanel\PhysicalController@listSuboptions')->name('physical.listSuboptions');
    Route::get('/physical/create-suboptions/{option}', 'Wpanel\PhysicalController@createSuboptions')->name('physical.createSuboptions');
    Route::post('/physical/store-suboptions', 'Wpanel\PhysicalController@storeSuboptions')->name('physical.storeSuboptions');
    Route::get('/physical/{id}/edit-suboptions', 'Wpanel\PhysicalController@editSuboptions')->name('physical.editSuboptions');
    Route::put('/physical/update-suboptions/{id}', 'Wpanel\PhysicalController@updateSuboptions')->name('physical.updateSuboptions');
    Route::post('/physical/enabled-suboptions', 'Wpanel\PhysicalController@enabledSuboptions')->name('physical.enabledSuboptions');
    Route::post('/physical/delete-suboptions', 'Wpanel\PhysicalController@deleteSuboptions')->name('physical.deleteSuboptions');

    Route::resource('/diagnostic', 'Wpanel\DiagnosticController')->except(['destroy', 'show']);
    Route::get('/diagnostic/list', 'Wpanel\DiagnosticController@list')->name('diagnostic.list');
    Route::post('/diagnostic/enabled', 'Wpanel\DiagnosticController@enabled')->name('diagnostic.enabled');
    Route::post('/diagnostic/delete', 'Wpanel\DiagnosticController@delete')->name('diagnostic.delete');

    Route::resource('/vaccine', 'Wpanel\VaccineController')->except(['destroy', 'show']);
    Route::get('/vaccine/list', 'Wpanel\VaccineController@list')->name('vaccine.list');
    Route::post('/vaccine/enabled', 'Wpanel\VaccineController@enabled')->name('vaccine.enabled');
    Route::post('/vaccine/delete', 'Wpanel\VaccineController@delete')->name('vaccine.delete');
});
