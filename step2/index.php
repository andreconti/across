<!DOCTYPE html>
<html>
<head>
    <title>Test | Step 2</title>
    
    <script type="text/javascript" src="vendor/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="vendor/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="vendor/js/it_IT.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="vendor/css/bootstrapValidator.css"/>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="page-header">
                <h2>Test | Step 2</h2>
            </div>

            <form id="defaultForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Parola check</label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="sWord" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary">Check word <span class="glyphicon glyphicon-ok-sign"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-message" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Esito controlli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#defaultForm')
        .bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                sWord: {
                    validators: {
                        notEmpty: {
                            message: 'Campo obbligatorio'
                        },
                        stringLength: {
                            message: 'Il campo deve contenere almeno 3 caratteri'
                        },
                        callback:{
                            message: 'L\'input non rispetta i requisiti richiesti'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();

            var $form = $(e.target);

            var bv = $form.data('bootstrapValidator');

            $.post("app/services/check.php", $form.serialize(), function(result) {
                
                if(result.valid){
                    $("#modal-message").find("p").html(result.message);
                    $("#modal-message").modal("show");
                }else{
                    switch(result.type)
                    {
                        case "lenght":
                            $form.data('bootstrapValidator').updateStatus('sWord', 'INVALID', "stringLength")
                            break;
                        case "check":
                            $form.data('bootstrapValidator').updateStatus('sWord', 'INVALID', "callback")
                            break;
                    }
                }
            }, 'json');
        });
});
</script>
</body>
</html>