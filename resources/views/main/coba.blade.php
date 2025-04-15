<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/css/formValidation.min.css" />
<link rel="stylesheet" href="http://formvalidation.io/vendor/jquery.steps/css/jquery.steps.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.min.js"></script>
<script src="http://formvalidation.io/vendor/jquery.steps/js/jquery.steps.min.js"></script>

<style>
.wizard > .content {
min-height: 20em !important;
}
.wizard .content > .body {
width: 100%;
height: auto;
padding: 15px;
position: relative;
}
</style>

<script>
$(document).ready(function () {
    function adjustIframeHeight() {
        var $body   = $('body'),
            $iframe = $body.data('iframe.fv');
        if ($iframe) {
            // Adjust the height of iframe
            $iframe.height($body.height());
        }
    }
    $("#multiphase").steps({
        headerTag: "h2",
        bodyTag: "section",
        saveState: true,
		onStepChanged: function(e, currentIndex, priorIndex) {
                // You don't need to care about it
                // It is for the specific demo
                adjustIframeHeight();
            },
            // Triggered when clicking the Previous/Next buttons
            onStepChanging: function(e, currentIndex, newIndex) {
                var fv         = $('#multiphase').data('formValidation'), // FormValidation instance
                    // The current step container
                    $container = $('#multiphase').find('section[data-step="' + currentIndex +'"]');

                // Validate the container
                fv.validateContainer($container);

                var isValidStep = fv.isValidContainer($container);
                if (isValidStep === false || isValidStep === null) {
                    // Do not jump to the next step
                    return false;
                }

                return true;
            },
            // Triggered when clicking the Finish button
            onFinishing: function(e, currentIndex) {
                var fv         = $('#multiphase').data('formValidation'),
                    $container = $('#multiphase').find('section[data-step="' + currentIndex +'"]');

                // Validate the last step container
                fv.validateContainer($container);

                var isValidStep = fv.isValidContainer($container);
                if (isValidStep === false || isValidStep === null) {
                    return false;
                }

                return true;
            },
            onFinished: function(e, currentIndex) {
                // Uncomment the following line to submit the form using the defaultSubmit() method
                //$('#multiphase').formValidation('defaultSubmit');

                // For testing purpose
                $('#welcomeModal').modal("show");
            }
        }).formValidation({
        excluded: ':disabled',
        message: 'This value is not valid',
        container: 'tooltip',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            //last name validation  
            sd_lastname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required and cannot be empty'
                    }
                }
            },
            //first name validation
            sd_firstname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            //validation of Parent's details step start
            //last name validation  
            pd_lastname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required and cannot be empty'
                    }
                }
            },
            //first name validation
            pd_firstname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            // Validation for Reference details starts
            //School reference name
            rd_schoolrefname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The School Reference Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 7,
                        max: 40,
                        message: 'The School Reference Name must be more than 7 and less than 40 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z\s]+$/i,
                        message: 'The School Reference Name can only consist of alphabetical characters'
                    }
                }
            },
            //School reference phone
            rd_schoolrefmobile: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Phone or Mobile is required and cannot be empty'
                    }
                }
            },
            rd_schoolrefemail: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The E-Mail ID is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /[a-zA-Z0-9]+(?:(\.|_)[A-Za-z0-9!#$%&'*+\/=?^`{|}~-]+)*@(?!([a-zA-Z0-9]*\.[a-zA-Z0-9]*\.[a-zA-Z0-9]*\.))(?:[A-Za-z0-9](?:[a-zA-Z0-9-]*[A-Za-z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?/g,
                        message: 'The E-Mail ID is not a valid E-Mail'
                    }
                }
            },
        }

    })

});
</script>

<div id="wrapper">
<!-- main container div-->
<div id="container" class="container">
	<div class="row">
		<div id="maincontent" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div id="" class="col-lg-12">
					<form id="multiphase" role="form" class="form-horizontal" action="" method="post">
							 <h2>Step</h2>
							<section data-step="0">
								 <h2>Student's Details:</h2>

								<hr>
								<div class="form-group">
									<label for="sd_lastname" class="col-lg-2 control-label">Last Name:</label>
									<div class="col-lg-3">
										<input type="text" name="sd_lastname" id="sd_lastname" class="form-control" placeholder="Last Name" value="" tabindex="1">
									</div>
								</div>
								<div class="form-group">
									<label for="sd_firstname" class="col-lg-2 control-label">First Name:</label>
									<div class="col-lg-3">
										<input type="text" name="sd_firstname" id="sd_firstname" class="form-control" placeholder="First Name" value="" tabindex="2">
									</div>
								</div>
							</section>
							 <h2>Step</h2>

							<section data-step="1">
								 <h2>Parent's Details:</h2>

								<hr>
								<div class="form-group">
									<label for="pd_lastname" class="col-lg-2 control-label">Last Name:</label>
									<div class="col-lg-3">
										<input type="text" name="pd_lastname" id="pd_lastname" class="form-control" placeholder="Last Name" value="" tabindex="1">
									</div>
								</div>
								<div class="form-group">
									<label for="pd_firstname" class="col-lg-2 control-label">First Name:</label>
									<div class="col-lg-3">
										<input type="text" name="pd_firstname" id="pd_firstname" class="form-control" placeholder="First Name" value="" tabindex="2">
									</div>
								</div>
							</section>
							 <h2>Step</h2>

							<section data-step="2">
								 <h2>Reference Details:</h2>

								<hr>
								<div class="form-group">
									<label for="rd_schoolrefname" class="col-lg-3 control-label">School Principal's Name:</label>
									<div class="col-lg-3">
										<input type="text" name="rd_schoolrefname" id="rd_schoolrefname" class="form-control" placeholder="First Name Last Name" value="" tabindex="1">
									</div>
								</div>
								<div class="form-group">
									<label for="rd_schoolrefmobile" class="col-lg-3 control-label">Phone or Mobile No.:</label>
									<div class="col-lg-2">
										<input type="text" name="rd_schoolrefmobile" id="rd_schoolrefmobile" class="form-control" placeholder="Phone or Mobile Number" data-mask="+99-99999-99999" value="" tabindex="2">
									</div>
								</div>
								<div class="form-group">
									<label for="rd_schoolrefemail" class="col-lg-3 control-label">E-Mail ID:</label>
									<div class="col-lg-3">
										<input type="text" name="rd_schoolrefemail" id="rd_schoolrefemail" class="form-control" placeholder="E-Mail ID" value="" tabindex="3">
									</div>
								</div>
							</section>
						<!-- end of wizard-->
					</form>
					<!-- end of form-->
				</div>
			</div>
			<!-- end of row-->
			<div class="modal fade" id="welcomeModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							 <h1 class="modal-title text-center">Add new last name</h1>

						</div>
						<div class="modal-body">
							<form method="POST" name="add_lastname">
								<input type="text" name="add_lastname" id="add_lastname" class="form-control" placeholder="Enter your last name here" value="">
								<p class="">The first alphabet of the last name <strong>MUST</strong> be in upper case.</p>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
							<input name="addlastname" type="submit" value="Add" class="btn btn-primary">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row hidden-print">
		<div id="footer" class="col-lg-12"></div>
	</div>
</div>
</div>