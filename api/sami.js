
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">Benoth</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Benoth_BoaCompra" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Benoth/BoaCompra.html">BoaCompra</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Benoth_BoaCompra_DataValidator" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/DataValidator.html">DataValidator</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_EndUser" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/EndUser.html">EndUser</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_Payment" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/Payment.html">Payment</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_PaymentCheckStatus" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/PaymentCheckStatus.html">PaymentCheckStatus</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_PaymentFormGenerator" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/PaymentFormGenerator.html">PaymentFormGenerator</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_PaymentNotification" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/PaymentNotification.html">PaymentNotification</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_PaymentPostBack" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/PaymentPostBack.html">PaymentPostBack</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_PropertyValidateAffect" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/PropertyValidateAffect.html">PropertyValidateAffect</a>                    </div>                </li>                            <li data-name="class:Benoth_BoaCompra_VirtualStoreIdentification" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Benoth/BoaCompra/VirtualStoreIdentification.html">VirtualStoreIdentification</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Benoth.html", "name": "Benoth", "doc": "Namespace Benoth"},{"type": "Namespace", "link": "Benoth/BoaCompra.html", "name": "Benoth\\BoaCompra", "doc": "Namespace Benoth\\BoaCompra"},
            
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/DataValidator.html", "name": "Benoth\\BoaCompra\\DataValidator", "doc": "&quot;Simple data validator.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_nonEmptyString", "name": "Benoth\\BoaCompra\\DataValidator::nonEmptyString", "doc": "&quot;Test if a string is non empty and shorter than a certain length.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_nonEmptyInt", "name": "Benoth\\BoaCompra\\DataValidator::nonEmptyInt", "doc": "&quot;Test if a string is non empty, with only numbers and shorter than a certain length.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_nonEmptyEmail", "name": "Benoth\\BoaCompra\\DataValidator::nonEmptyEmail", "doc": "&quot;Test if an email is valid and shorter than a certain length.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_nonEmptyUrl", "name": "Benoth\\BoaCompra\\DataValidator::nonEmptyUrl", "doc": "&quot;Test if an URL is valid and shorter than a certain length.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_validUrl", "name": "Benoth\\BoaCompra\\DataValidator::validUrl", "doc": "&quot;Test if an URL is valid, uses port 80 or 443 and shorter than a certain length.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_validLanguage", "name": "Benoth\\BoaCompra\\DataValidator::validLanguage", "doc": "&quot;Test if a Language code is valid.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_validCurrencyCode", "name": "Benoth\\BoaCompra\\DataValidator::validCurrencyCode", "doc": "&quot;Test if a Currency code is valid.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_validStringBool", "name": "Benoth\\BoaCompra\\DataValidator::validStringBool", "doc": "&quot;Test if a string represent a boolean.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\DataValidator", "fromLink": "Benoth/BoaCompra/DataValidator.html", "link": "Benoth/BoaCompra/DataValidator.html#method_maxLength", "name": "Benoth\\BoaCompra\\DataValidator::maxLength", "doc": "&quot;Test if a string is shorter than a certain length.&quot;"},
            
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/EndUser.html", "name": "Benoth\\BoaCompra\\EndUser", "doc": "&quot;BoaCompra End User.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method___construct", "name": "Benoth\\BoaCompra\\EndUser::__construct", "doc": "&quot;Create a new End User.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getEmail", "name": "Benoth\\BoaCompra\\EndUser::getEmail", "doc": "&quot;Get the End User Email.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getName", "name": "Benoth\\BoaCompra\\EndUser::getName", "doc": "&quot;Get the End User Full name.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getNumber", "name": "Benoth\\BoaCompra\\EndUser::getNumber", "doc": "&quot;Get the End User Address number.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getStreet", "name": "Benoth\\BoaCompra\\EndUser::getStreet", "doc": "&quot;Get the End User Address \/ Street.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getSubUrb", "name": "Benoth\\BoaCompra\\EndUser::getSubUrb", "doc": "&quot;Get the End User SubUrb.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getZipcode", "name": "Benoth\\BoaCompra\\EndUser::getZipcode", "doc": "&quot;Get the End User Postal code.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getCity", "name": "Benoth\\BoaCompra\\EndUser::getCity", "doc": "&quot;Get the End User City.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getState", "name": "Benoth\\BoaCompra\\EndUser::getState", "doc": "&quot;Get the End User State.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getCountry", "name": "Benoth\\BoaCompra\\EndUser::getCountry", "doc": "&quot;Get the End User Country.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getPhone", "name": "Benoth\\BoaCompra\\EndUser::getPhone", "doc": "&quot;Get the End User Phone.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getCPF", "name": "Benoth\\BoaCompra\\EndUser::getCPF", "doc": "&quot;Get the End User CPF.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getLanguage", "name": "Benoth\\BoaCompra\\EndUser::getLanguage", "doc": "&quot;Get the End User Language.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_getCharacter", "name": "Benoth\\BoaCompra\\EndUser::getCharacter", "doc": "&quot;Get the End User Character name or Player login.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setName", "name": "Benoth\\BoaCompra\\EndUser::setName", "doc": "&quot;Set the End User Full name (max length 60)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setNumber", "name": "Benoth\\BoaCompra\\EndUser::setNumber", "doc": "&quot;Set the End User Address number (max length 10).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setStreet", "name": "Benoth\\BoaCompra\\EndUser::setStreet", "doc": "&quot;Set the End User Address \/ Street (max length 60).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setSubUrb", "name": "Benoth\\BoaCompra\\EndUser::setSubUrb", "doc": "&quot;Set the End User Suburb (max length 60).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setZipcode", "name": "Benoth\\BoaCompra\\EndUser::setZipcode", "doc": "&quot;Set the End Postal code (numbers only) (max length 8).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setCity", "name": "Benoth\\BoaCompra\\EndUser::setCity", "doc": "&quot;Set the End User City (max length 20)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setState", "name": "Benoth\\BoaCompra\\EndUser::setState", "doc": "&quot;Set the End User State (max length 20)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setCountry", "name": "Benoth\\BoaCompra\\EndUser::setCountry", "doc": "&quot;Set the End User Country (max length 20)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setPhone", "name": "Benoth\\BoaCompra\\EndUser::setPhone", "doc": "&quot;Set the End User Phone Number (max length 20)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setCPF", "name": "Benoth\\BoaCompra\\EndUser::setCPF", "doc": "&quot;Set the End User CPF (for Brazil only) (max length 20)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setLanguage", "name": "Benoth\\BoaCompra\\EndUser::setLanguage", "doc": "&quot;Set the End User Language (max length 5)\nValid values : pt&lt;em&gt;BR, es&lt;\/em&gt;ES, en&lt;em&gt;US, pt&lt;\/em&gt;PT, tr_TR.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\EndUser", "fromLink": "Benoth/BoaCompra/EndUser.html", "link": "Benoth/BoaCompra/EndUser.html#method_setCharacter", "name": "Benoth\\BoaCompra\\EndUser::setCharacter", "doc": "&quot;Set the End User Character name or Player login (max length 100)\nProvides anti-fraud analysis and semi-transparent checkout.&quot;"},
            
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/Payment.html", "name": "Benoth\\BoaCompra\\Payment", "doc": "&quot;Generate the payment to sends a payment request to BoaCompra.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method___construct", "name": "Benoth\\BoaCompra\\Payment::__construct", "doc": "&quot;Create a new Payment.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getBillingURL", "name": "Benoth\\BoaCompra\\Payment::getBillingURL", "doc": "&quot;Get the BoaCompra Billing URL.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getVirtualStoreIdentification", "name": "Benoth\\BoaCompra\\Payment::getVirtualStoreIdentification", "doc": "&quot;Get the Virtual Store Identification.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getEndUser", "name": "Benoth\\BoaCompra\\Payment::getEndUser", "doc": "&quot;Get the End User.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getReturnURL", "name": "Benoth\\BoaCompra\\Payment::getReturnURL", "doc": "&quot;Get the Virtual Store URL used to redirect end users in successful transactions.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getNotifyURL", "name": "Benoth\\BoaCompra\\Payment::getNotifyURL", "doc": "&quot;Get the Virtual Store URL used by BoaCompra to notify a new payment.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getCurrencyCode", "name": "Benoth\\BoaCompra\\Payment::getCurrencyCode", "doc": "&quot;Get the Currency code.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getOrderId", "name": "Benoth\\BoaCompra\\Payment::getOrderId", "doc": "&quot;Get the Order Id.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getOrderDescription", "name": "Benoth\\BoaCompra\\Payment::getOrderDescription", "doc": "&quot;Get the Order description.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getAmount", "name": "Benoth\\BoaCompra\\Payment::getAmount", "doc": "&quot;Get the Amount.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getCountryIso", "name": "Benoth\\BoaCompra\\Payment::getCountryIso", "doc": "&quot;Get the Country ISO.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getProjectId", "name": "Benoth\\BoaCompra\\Payment::getProjectId", "doc": "&quot;Get the Project ID.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getPaymentId", "name": "Benoth\\BoaCompra\\Payment::getPaymentId", "doc": "&quot;Get the Payment ID (payment method).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getPaymentGroup", "name": "Benoth\\BoaCompra\\Payment::getPaymentGroup", "doc": "&quot;Get the Payment Group (used to show a specific group of payment methods to the End User).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getToken", "name": "Benoth\\BoaCompra\\Payment::getToken", "doc": "&quot;Get the Access token provided by external partner for authentication.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_getTestMode", "name": "Benoth\\BoaCompra\\Payment::getTestMode", "doc": "&quot;Get the Test mode (0 = Prod, 1 = Test).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_setCountryIso", "name": "Benoth\\BoaCompra\\Payment::setCountryIso", "doc": "&quot;Set the ISO Code of the country from which the payment methods must be displayed without\nshowing the country selection page to the End User (max length 2).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_setProjectId", "name": "Benoth\\BoaCompra\\Payment::setProjectId", "doc": "&quot;Set the Project Identifier (max length 6).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_setPaymentId", "name": "Benoth\\BoaCompra\\Payment::setPaymentId", "doc": "&quot;Set the Payment Identifier (max length 6)\nThis parameter is used to show a specific payment method to the final user.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_setPaymentGroup", "name": "Benoth\\BoaCompra\\Payment::setPaymentGroup", "doc": "&quot;Set the Payment group name (max length 20)\nThis parameter is used to show a specific group of payment methods to the End User.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_setToken", "name": "Benoth\\BoaCompra\\Payment::setToken", "doc": "&quot;Set the Access token provided by external partner for authentication (max length 32)\nPlease contact your Account Manager for further information.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\Payment", "fromLink": "Benoth/BoaCompra/Payment.html", "link": "Benoth/BoaCompra/Payment.html#method_setTestMode", "name": "Benoth\\BoaCompra\\Payment::setTestMode", "doc": "&quot;Parameter used to indicate that a transaction will be processed in test mode (valid values : 0 \/ 1)\nCan be used the value \&quot;1\&quot; to test integration and \&quot;0\&quot; to production environment.&quot;"},
            
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/PaymentCheckStatus.html", "name": "Benoth\\BoaCompra\\PaymentCheckStatus", "doc": "&quot;Send a check status to BoaCompra to get the order status.&quot;"},
                    
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/PaymentFormGenerator.html", "name": "Benoth\\BoaCompra\\PaymentFormGenerator", "doc": "&quot;Generate the payment form to sends a payment request to BoaCompra.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentFormGenerator", "fromLink": "Benoth/BoaCompra/PaymentFormGenerator.html", "link": "Benoth/BoaCompra/PaymentFormGenerator.html#method___construct", "name": "Benoth\\BoaCompra\\PaymentFormGenerator::__construct", "doc": "&quot;Create a new form generator.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentFormGenerator", "fromLink": "Benoth/BoaCompra/PaymentFormGenerator.html", "link": "Benoth/BoaCompra/PaymentFormGenerator.html#method_render", "name": "Benoth\\BoaCompra\\PaymentFormGenerator::render", "doc": "&quot;Render a full HTML form.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentFormGenerator", "fromLink": "Benoth/BoaCompra/PaymentFormGenerator.html", "link": "Benoth/BoaCompra/PaymentFormGenerator.html#method_renderFormOpen", "name": "Benoth\\BoaCompra\\PaymentFormGenerator::renderFormOpen", "doc": "&quot;Render a HTML form open tag.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentFormGenerator", "fromLink": "Benoth/BoaCompra/PaymentFormGenerator.html", "link": "Benoth/BoaCompra/PaymentFormGenerator.html#method_renderFormContent", "name": "Benoth\\BoaCompra\\PaymentFormGenerator::renderFormContent", "doc": "&quot;Render the BoaCompra HTML form content (list of inputs hidden).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentFormGenerator", "fromLink": "Benoth/BoaCompra/PaymentFormGenerator.html", "link": "Benoth/BoaCompra/PaymentFormGenerator.html#method_renderFormClose", "name": "Benoth\\BoaCompra\\PaymentFormGenerator::renderFormClose", "doc": "&quot;Render a HTML form close tag.&quot;"},
            
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/PaymentNotification.html", "name": "Benoth\\BoaCompra\\PaymentNotification", "doc": "&quot;Process the notification received from BoaCompra, informing that the payment has cleared.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentNotification", "fromLink": "Benoth/BoaCompra/PaymentNotification.html", "link": "Benoth/BoaCompra/PaymentNotification.html#method___construct", "name": "Benoth\\BoaCompra\\PaymentNotification::__construct", "doc": "&quot;Create a new BoaCompra notification checker\nAll parameters (except $payment) must the datas received by distant server\n(generally from $&lt;em&gt;POST except for $ipAddress which generallyis taken in $&lt;\/em&gt;SERVER).&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentNotification", "fromLink": "Benoth/BoaCompra/PaymentNotification.html", "link": "Benoth/BoaCompra/PaymentNotification.html#method_getPayment", "name": "Benoth\\BoaCompra\\PaymentNotification::getPayment", "doc": "&quot;Get the payment object.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentNotification", "fromLink": "Benoth/BoaCompra/PaymentNotification.html", "link": "Benoth/BoaCompra/PaymentNotification.html#method_getTransactionId", "name": "Benoth\\BoaCompra\\PaymentNotification::getTransactionId", "doc": "&quot;Get the Transaction Id sent by BoaCompra.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentNotification", "fromLink": "Benoth/BoaCompra/PaymentNotification.html", "link": "Benoth/BoaCompra/PaymentNotification.html#method_getCurrencyCode", "name": "Benoth\\BoaCompra\\PaymentNotification::getCurrencyCode", "doc": "&quot;Get the Currency Code sent by BoaCompra.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentNotification", "fromLink": "Benoth/BoaCompra/PaymentNotification.html", "link": "Benoth/BoaCompra/PaymentNotification.html#method_getPaymentId", "name": "Benoth\\BoaCompra\\PaymentNotification::getPaymentId", "doc": "&quot;Get the Payment Id (End User payment method) sent by BoaCompra.&quot;"},
            
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/PaymentPostBack.html", "name": "Benoth\\BoaCompra\\PaymentPostBack", "doc": "&quot;Send the postback to BoaCompra to confirm the order once the notification is received.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentPostBack", "fromLink": "Benoth/BoaCompra/PaymentPostBack.html", "link": "Benoth/BoaCompra/PaymentPostBack.html#method___construct", "name": "Benoth\\BoaCompra\\PaymentPostBack::__construct", "doc": "&quot;Create the PaymentPostBack.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentPostBack", "fromLink": "Benoth/BoaCompra/PaymentPostBack.html", "link": "Benoth/BoaCompra/PaymentPostBack.html#method_getPaymentNotification", "name": "Benoth\\BoaCompra\\PaymentPostBack::getPaymentNotification", "doc": "&quot;Get the Notification object.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\PaymentPostBack", "fromLink": "Benoth/BoaCompra/PaymentPostBack.html", "link": "Benoth/BoaCompra/PaymentPostBack.html#method_validatePayment", "name": "Benoth\\BoaCompra\\PaymentPostBack::validatePayment", "doc": "&quot;Validate the payment.&quot;"},
            
            {"type": "Trait", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/PropertyValidateAffect.html", "name": "Benoth\\BoaCompra\\PropertyValidateAffect", "doc": "&quot;\n&quot;"},
                    
            {"type": "Class", "fromName": "Benoth\\BoaCompra", "fromLink": "Benoth/BoaCompra.html", "link": "Benoth/BoaCompra/VirtualStoreIdentification.html", "name": "Benoth\\BoaCompra\\VirtualStoreIdentification", "doc": "&quot;BoaCompra Virtual Store Identification.&quot;"},
                                                        {"type": "Method", "fromName": "Benoth\\BoaCompra\\VirtualStoreIdentification", "fromLink": "Benoth/BoaCompra/VirtualStoreIdentification.html", "link": "Benoth/BoaCompra/VirtualStoreIdentification.html#method___construct", "name": "Benoth\\BoaCompra\\VirtualStoreIdentification::__construct", "doc": "&quot;Create a new Virtual Store Identification.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\VirtualStoreIdentification", "fromLink": "Benoth/BoaCompra/VirtualStoreIdentification.html", "link": "Benoth/BoaCompra/VirtualStoreIdentification.html#method_getStoreId", "name": "Benoth\\BoaCompra\\VirtualStoreIdentification::getStoreId", "doc": "&quot;Get the Store ID.&quot;"},
                    {"type": "Method", "fromName": "Benoth\\BoaCompra\\VirtualStoreIdentification", "fromLink": "Benoth/BoaCompra/VirtualStoreIdentification.html", "link": "Benoth/BoaCompra/VirtualStoreIdentification.html#method_getKey", "name": "Benoth\\BoaCompra\\VirtualStoreIdentification::getKey", "doc": "&quot;Get the Store Secret Key.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


