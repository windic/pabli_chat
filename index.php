<!-- Upload Code -->
<?php 
    $IP_DEST = "192.168.1.39";
    $error = false;
    if (!empty($_POST)) {
        if (isset($_POST["message"]) && !empty($_POST["message"])) {
            $message = $_POST["message"];
            $file = fopen("last_message.txt", "w");
            fwrite($file, $message);
            fclose($file);
            shell_exec("mosquitto_pub -h " . $IP_DEST . " -t e -m \"" . $message . "\"");
        } else {
            $error = true;
        }
    }
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat+Alternates:400,500" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <title>Pabli Chat</title>

    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand" href="">
            <span class="logo">
                Pabli Chat
                <i class="fab fa-rocketchat"></i>
            </span>
        </a>
    </nav>
    
    <!-- Success Alert -->
    <?php if (isset($message)):?>
    <div class="alert alert-success" role="alert">
        El mensaje: "<?php echo $message; ?>", ha sido enviado correctamente
    </div>
    <?php endif;?>

    <!-- Error Alert -->
    <?php if ($error): ?>
    <div class="alert alert-danger" role="alert">
        ERROR: ha ocurrido un error y no se ha mandado nigun mensaje
    </div>
    <?php endif;?>

    <!-- Content-->
    <section class="container border p-3 p-sm-5 mt-0 mt-sm-4">
        
        <!-- Opened Model -->
        <button type="button" id="lastMessage" class="btn btn-secondary" data-toggle="modal" data-target="#lastMessageModal">Último mensaje</button>
        
        <!-- Form Message -->
        <form action="" method="post">

            <!-- Message input -->
            <div class="form-group row">
                <label for="message" class="col-sm-12 col-form-label">mensaje:</label>
                <div class="col-sm-12">
                    <textarea class="form-control" name="message" id="message"></textarea>
                </div>
            </div>

            <!-- Submit button -->
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary ">Enviar</button>
                </div>
            </div>
        </form>
    </section>

    <!-- Modal Last Message-->
    <div class="modal fade" id="lastMessageModal" tabindex="-1" role="dialog" aria-labelledby="lastMessageLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lastMessageLabel">Último mensaje enviado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="lastMessageText"></span>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        setTimeout(() => {
            $(".alert").alert('close')
        }, 2500);
        $('#lastMessageModal').on('show.bs.modal', function (e) {
            readLastMessage()
        })

        /**
         * Read the file message when the modal its opened
         */
        function readLastMessage() {
            $.ajax({
                url: "last_message.txt",
                success: function (data){
                    $("#lastMessageText").text(data)
                }
            });
        }
    </script>
</body>
</html>