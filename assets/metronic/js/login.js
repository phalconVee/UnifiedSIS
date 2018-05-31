//== Class Definition
var SnippetLogin = function() {

    var login = $('#m_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        alert.animateClass('fadeIn animated');
        alert.find('span').html(msg);
    }

    //== Private Functions

    var displaySignUpForm = function() {
        login.removeClass('m-login--forget-password');
        login.removeClass('m-login--signin');

        login.addClass('m-login--signup');
        login.find('.m-login__signup').animateClass('flipInX animated');
    }

    var displaySignInForm = function() {
        login.removeClass('m-login--forget-password');
        login.removeClass('m-login--signup');

        login.addClass('m-login--signin');
        login.find('.m-login__signin').animateClass('flipInX animated');
    }

    var displayForgetPasswordForm = function() {
        login.removeClass('m-login--signin');
        login.removeClass('m-login--signup');

        login.addClass('m-login--forget-password');
        login.find('.m-login__forget-password').animateClass('flipInX animated');
    }

    var handleFormSwitch = function() {
        $('#m_login_forget_password').click(function(e) {
            e.preventDefault();
            displayForgetPasswordForm();
        });

        $('#m_login_forget_password_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });

        $('#m_login_signup').click(function(e) {
            e.preventDefault();
            displaySignUpForm();
        });

        $('#m_login_signup_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });
    }

    var handleSignInFormSubmit = function() {
        $('#m_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    username: {
                        required: true,
                        //username: true
                    },
                    password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: siteUrl + 'index.php?login/ajax_login',
                method: 'POST',
                dataType: 'json',
                data: {
                    username: $("input#username").val(),
                    password: $("input#password").val()
                },
                error: function()
                {
                    alert("An error occurred!");
                },
                success: function(response) {

                    // Login status [success|invalid]
                    var login_status = response.login_status;

                	// similate 2s delay
                	setTimeout(function() {

                        // If login is invalid, we store the
                        if(login_status == 'invalid')
                        {
                            //do something if response is invalid
                            btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            showErrorMsg(form, 'danger', 'Incorrect username or password. Please try again.');
                        }
                        else
                        if(login_status == 'success')
                        {
                            // Redirect to login page
                            setTimeout(function()
                            {
                                var redirect_url = siteUrl;
                                //var redirect_url = baseurl + 'index.php?login';

                                if(response.redirect_url && response.redirect_url.length)
                                {
                                    redirect_url = response.redirect_url;
                                }

                                window.location.href = redirect_url;
                            }, 400);
                        }

                    }, 1000);
                }
            });
        });
    }

    var handleSignUpFormSubmit = function() {
        $('#m_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    fullname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        required: true
                    },
                    agree: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                	setTimeout(function() {
	                    btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
	                    form.clearForm();
	                    form.validate().resetForm();

	                    // display signup form
	                    displaySignInForm();
	                    var signInForm = login.find('.m-login__signin form');
	                    signInForm.clearForm();
	                    signInForm.validate().resetForm();

	                    showErrorMsg(signInForm, 'success', 'Thank you. To complete your registration please check your email.');
	                }, 2000);
                }
            });
        });
    }

    var handleForgetPasswordFormSubmit = function() {
        $('#m_login_forget_password_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: siteUrl + 'index.php?login/ajax_forgot_password',
                method: 'POST',
                dataType: 'json',
                data: {
                    m_email: $("input#m_email").val()
                },
                error: function()
                {
                    alert("An error occurred!");
                },
                success: function(response) {

                    // From response you can fetch the data object retured
                    var email = response.submitted_data.m_email;

                    var status = response.status;

                    //console.log(email);

                	// similate 2s delay
                	setTimeout(function() {

                        if (status == 'true')
                        {
                            btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false); // remove
                            form.clearForm(); // clear form
                            form.validate().resetForm(); // reset validation states

                            // display signup form
                            displaySignInForm();
                            var signInForm = login.find('.m-login__signin form');
                            signInForm.clearForm();
                            signInForm.validate().resetForm();

                            showErrorMsg(signInForm, 'success', 'Reset email has been sent. Password recovery instruction has been sent to your email.');
                        }

                        else if (status == 'false')
                        {
                            btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            showErrorMsg(form, 'danger', 'Invalid Email. This email does not exist on our records. Please try again.');
                        }

                	}, 2000);
                }
            });
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleFormSwitch();
            handleSignInFormSubmit();
            handleSignUpFormSubmit();
            handleForgetPasswordFormSubmit();
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetLogin.init();
});